<?php

namespace App\Domain\Spin;

use App\Domain\Landing\Landing;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Spin extends Model
{
    protected $fillable = [
        'landing_id',
        'num',
        'score',
        'amount',
    ];

    protected $appends = [
        'is_win',
    ];

    public static function amountInUsd(?float $amount): string
    {
        return sprintf('%.2f$', $amount);
    }

    public function toDto(): SpinDto
    {
        return new SpinDto(
            array_merge(
                $this->only('num', 'score', 'amount', 'is_win'),
                ['landing_hash_id' => $this->landing->hash]
            )
        );
    }

    public function landing()
    {
        return $this->belongsTo(Landing::class);
    }

    public function getAmountInUsd(): string
    {
        return self::amountInUsd($this->amount);
    }

    public function isWin(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->amount > 0,
            set: fn() => throw new \BadMethodCallException('This attribute can\'t be assigned')
        );
    }

}
