<?php

namespace App\Domain\Landing;

use App\Domain\Landing\Exceptions\PageExpiredException;
use App\Domain\Landing\Exceptions\PageTrashedException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyLandingMiddleware
{
    public function __construct(
        protected LandingCrudService $landings,
        protected LandingVerifierService $verifier
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $key): Response
    {
        $hashId  = $request->route($key) ?? $request->input($key);
        $landing = $this->landings->findByHash($hashId);

        try {
            $this->verifier->validate($landing);
        } catch (PageTrashedException) {
            abort(404, 'This page is not available anymore');
        } catch (PageExpiredException) {
            $this->landings->deactivate($landing);

            if ($request->isMethod('GET') && !$request->wantsJson()) {
                return redirect()->refresh();
            }

            // Instruct developer that he must refresh page, redirect or handle accordingly
            abort(409, 'This page got expired');
        }

        return $next($request);
    }

}
