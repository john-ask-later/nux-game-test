<?php

namespace App\Http\Controllers;

use App\Domain\Landing\LandingService;
use App\Domain\Spin\SpinHistoryService;
use App\Domain\Spin\SpinService;

class SpinController extends Controller
{
    public function __construct(
        protected LandingService $landings,
        protected SpinService $spins,
        protected SpinHistoryService $history
    ) {

    }

    public function spin(string $landingHashId)
    {
        $landing = $this->landings->findByHash($landingHashId);
        $spin    = $this->spins->create($landing->id);

        return ['result' => view('spin.result', compact('spin'))->render()];
    }

    public function latest(string $landingHashId)
    {
        $landing = $this->landings->findByHash($landingHashId);
        $list    = $this->history->getLatest($landing->id);

        return ['result' => view('spin.history', compact('list'))->render()];
    }

}
