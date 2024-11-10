<?php

namespace App\Http\Controllers;

use App\Domain\Spin\SpinService;

class SpinController extends Controller
{
    public function __construct(
        protected SpinService $spins,
    ) {
    }

    public function spin(string $landingHashId): array
    {
        $spin = $this->spins->create($landingHashId);

        return ['result' => view('components.spin.result', compact('spin'))->render()];
    }

    public function latest(string $landingHashId): array
    {
        $list = $this->spins->getLatest($landingHashId);

        return ['result' => view('components.spin.history', compact('list'))->render()];
    }

}
