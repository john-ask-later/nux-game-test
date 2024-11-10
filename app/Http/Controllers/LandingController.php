<?php

namespace App\Http\Controllers;

use App\Domain\Landing\LandingCrudService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __construct(
        protected LandingCrudService $landings
    ) {
    }

    public function show(Request $request, string $hashId): View|RedirectResponse
    {
        $landing = $this->landings->findByHash($hashId);
        $hashId  = $request->query('new-hash');

        return view('landing', compact('landing', 'hashId'));
    }

    public function regenerate(string $hashId): RedirectResponse
    {
        $landing = $this->landings->regenerate(
            $this->landings->findByHash($hashId)
        );

        return to_route('landing.show', ['hash' => $hashId, 'new-hash' => (string)$landing->hash]);
    }

    public function deactivate(string $hashId): RedirectResponse
    {
        $this->landings->deactivate(
            $this->landings->findByHash($hashId)
        );

        return to_route('home');
    }

}
