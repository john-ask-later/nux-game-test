<?php

namespace App\Domain\Spin;

interface HistoryInterface
{
    /**
     * Get total count of user made spins.
     *
     * @param string $landingHashId
     *
     * @return int
     */
    public function getSpinsCount(string $landingHashId): int;

    /**
     * Save new spin into history manager.
     *
     * @param SpinDto $spinDto
     *
     * @return void
     */
    public function saveSpin(SpinDto $spinDto): void;

    /**
     * Get 3 latest spins made by user.
     *
     * @param string $landingHashId
     *
     * @return array<int, SpinDto>
     */
    public function getLatest(string $landingHashId): array;
}
