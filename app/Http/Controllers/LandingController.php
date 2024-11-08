<?php

namespace App\Http\Controllers;

use App\Domain\Landing\Exceptions\PageExpiredException;
use App\Domain\Landing\Exceptions\PageTrashedException;
use App\Domain\Landing\LandingService;
use App\Domain\Landing\LandingVerifierService;
use App\Domain\Spin\SpinService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __construct(
        protected LandingService $landings,
        protected LandingVerifierService $verifier
    ) {
    }

    public function show(string $hash): View|RedirectResponse
    {
        $landing = $this->landings->findByHash($hash);

        try {
            $this->verifier->validate($landing);
        } catch (PageTrashedException) {
            abort(403, 'This page is not available anymore');
        } catch (PageExpiredException) {
            $this->landings->deactivate($landing);

            return redirect()->refresh();
        }

        return \view('landing', compact('landing'));
    }

    public function regenerate(string $hashId): RedirectResponse
    {
        $landing = $this->landings->regenerate(
            $this->landings->findByHash($hashId)
        );

        return redirect(
            action([__CLASS__, 'show'], $landing->hash)
        );
    }

    public function deactivate(string $hashId): RedirectResponse
    {
        $this->landings->deactivate(
            $this->landings->findByHash($hashId)
        );

        return redirect(
            action([HomeController::class, 'index'])
        );
    }

}
