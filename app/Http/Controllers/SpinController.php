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

        return compact('spin');
    }

    public function latest(string $landingHashId): array
    {
        return [
            'spins' => $this->spins->getLatest($landingHashId)
        ];
    }

}
