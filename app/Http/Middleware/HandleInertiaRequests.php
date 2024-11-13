<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Inertia\Support\Header;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
        ];
    }

    /**
     * Resolves and prepares validation errors in such
     * a way that they are easier to use client-side.
     *
     * @return object
     */
    public function resolveValidationErrors(Request $request)
    {
        if (!$request->hasSession() || !$request->session()->has('errors')) {
            return (object) [];
        }

        return (object) collect($request->session()->get('errors')->getBags())
            ->map(function ($bag) {
                return (object) collect($bag->messages())
                    ->map(function ($errors) {
                        return $errors;
                    })
                    ->toArray();
            })
            ->pipe(function ($bags) use ($request) {
                if ($bags->has('default') && $request->header(Header::ERROR_BAG)) {
                    return [$request->header(Header::ERROR_BAG) => $bags->get('default')];
                }

                if ($bags->has('default')) {
                    return $bags->get('default');
                }

                return $bags->toArray();
            });
    }

}
