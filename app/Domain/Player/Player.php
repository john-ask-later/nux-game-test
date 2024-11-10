<?php

namespace App\Domain\Player;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Dummy model to represent registered user.
 */
class Player extends Model
{
    protected $fillable = [
        'name',
        'phone',
    ];

    /**
     * Simple setter to remove whitespaces from phone number
     *
     * @return Attribute
     */
    public function phone(): Attribute
    {
        return Attribute::make(
            set: fn($value) => preg_replace('/\s/', '', $value)
        );
    }

}
