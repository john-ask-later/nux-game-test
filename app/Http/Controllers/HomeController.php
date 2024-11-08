<?php

namespace App\Http\Controllers;

use App\Domain\Landing\LandingService;
use App\Domain\Player\CreatePlayerRequest;
use App\Domain\Player\PlayerService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected PlayerService $players,
        protected LandingService $landings
    ) {

    }

    public function index(Request $request): View
    {
        $hash = $request->query('hash');
        $link = $hash ? action([LandingController::class, 'show'], $hash) : null;

        return \view('home', compact('link', 'hash'));
    }

    public function store(CreatePlayerRequest $request)
    {
        $player  = $this->players->createPlayer($request->validated());
        $landing = $this->landings->create($player->id);

        return redirect()->action([__CLASS__, 'index'], ['hash' => (string)$landing->hash]);
    }

}
