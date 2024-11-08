<?php

namespace App\Domain\Player;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'phone',
    ];

}
