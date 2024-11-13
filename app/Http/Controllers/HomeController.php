<?php

namespace App\Http\Controllers;

use App\Domain\Landing\LandingCrudService;
use App\Domain\Player\CreatePlayerRequest;
use App\Domain\Player\PlayerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        protected PlayerService $players,
        protected LandingCrudService $landings
    ) {

    }

    /**
     * Main action to show registration form and lucky link with (if) provided hash ID.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $hashId  = $request->query('hash');
        $playerN = $hashId ? $this->landings->findByHash($hashId)?->playerName : null;

        return Inertia::render('Home', [
            'hashId'  => $hashId,
            'playerN' => $playerN,
        ]);
    }

    /**
     * Create player and make new landing for him.
     *
     * @param CreatePlayerRequest $request
     *
     * @return RedirectResponse
     */
    public function store(CreatePlayerRequest $request): RedirectResponse
    {
        $player  = $this->players->createPlayer($request->validated());
        $landing = $this->landings->create($player->id);

        // I've decided not to make it via ajax, to allow users to save the url of the page with lucky link
        return to_route('home', ['hash' => (string) $landing->hash]);
    }

}
