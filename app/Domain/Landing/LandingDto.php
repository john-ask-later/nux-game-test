<?php

namespace App\Domain\Landing;

use Illuminate\Support\Carbon;
use Illuminate\Support\Fluent;

/**
 * @property int     $id
 * @property int     $player_id
 * @property string  $hash
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property ?Carbon $deleted_at
 * @property string  $player_name
 */
class LandingDto extends Fluent
{

}
