<?php

namespace App\Domain\Spin;

class SpinService
{
    public function create(int $landingId): Spin
    {
        $attributes = $this->spin();

        $attributes['landing_id'] = $landingId;
        $attributes['num']        = (Spin::where('landing_id', $landingId)->max('num') ?? 0) + 1;

        return Spin::create($attributes);
    }

    public function spin(): array
    {
        $score = $this->getScore();

        if (0 < $score % 2) {
            $amount = 0;
        } else {
            $amount = match (true) {
                $score > 900 => $score * .7,
                $score > 600 => $score * .5,
                $score > 300 => $score * .3,
                default => $score * .1
            };
        }

        return compact('score', 'amount');
    }

    public function getScore(): int
    {
        return mt_rand(1, 1000);
    }

}
