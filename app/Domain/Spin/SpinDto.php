<?php

namespace App\Domain\Spin;

use Illuminate\Support\Fluent;

/**
 * @property string $landing_hash_id
 * @property int    $num
 * @property int    $score
 * @property float  $amount
 * @property string $amount_in_usd
 * @property bool   $is_win
 */
class SpinDto extends Fluent
{
    public static function fromJson(string $json): SpinDto
    {
        return new SpinDto(
            json_decode($json, true)
        );
    }

    public function getAmountInUsd(): string
    {
        return Spin::amountInUsd($this->amount);
    }

}
