<?php

namespace App\Http\Controllers;

use App\Domain\Landing\LandingCrudService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LandingController extends Controller
{
    public function __construct(
        protected LandingCrudService $landings
    ) {
    }

    public function show(Request $request, string $hashId): Response
    {
        $landing   = $this->landings->findByHash($hashId);
        $newHashId = $request->query('new-hash');

        return Inertia::render('Landing', [
            'hashId'    => $hashId,
            'newHashId' => $newHashId,
            'playerN'   => $landing->playerName,
            'timeLeft'  => $landing->getTimeToExpiration(),
        ]);
    }

    public function regenerate(string $hashId): RedirectResponse
    {
        $landing = $this->landings->regenerate(
            $this->landings->findByHash($hashId)
        );

        return to_route('landing.show', ['hash' => $hashId, 'new-hash' => (string) $landing->hash]);
    }

    public function deactivate(string $hashId): RedirectResponse
    {
        $this->landings->deactivate(
            $this->landings->findByHash($hashId)
        );

        return to_route('home');
    }

}
