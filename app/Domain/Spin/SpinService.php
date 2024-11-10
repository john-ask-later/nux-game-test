<?php

namespace App\Domain\Spin;

class SpinService
{
    public function __construct(
        protected HistoryInterface $history
    ) {
    }

    public function create(string $landingHashId): SpinDto
    {
        $attributes = $this->makeSpin();

        $attributes['landing_hash_id'] = $landingHashId;

        $attributes['num'] = $this->getSpinNumber($landingHashId);

        $spinDto = new SpinDto($attributes);

        $this->history->saveSpin($spinDto);

        return $spinDto;
    }

    /**
     * @param string $landingHashId
     *
     * @return array<int, SpinDto>
     */
    public function getLatest(string $landingHashId): array
    {
        return $this->history->getLatest($landingHashId);
    }

    public function makeSpin(): array
    {
        $score = $this->getScore();

        if (0 < $score % 2) {
            $amount = 0;
            $is_win = false;
        } else {
            $amount = match (true) {
                $score > 900 => $score * .7,
                $score > 600 => $score * .5,
                $score > 300 => $score * .3,
                default => $score * .1
            };

            $is_win = true;
        }

        return compact('score', 'amount', 'is_win');
    }

    public function getScore(): int
    {
        return mt_rand(1, 1000);
    }

    public function getSpinNumber(string $landingHashId): int
    {
        return $this->history->getSpinsCount($landingHashId) + 1;
    }

}
