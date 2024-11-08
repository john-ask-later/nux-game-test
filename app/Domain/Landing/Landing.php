<?php

namespace App\Domain\Landing;

use App\Domain\Player\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Landing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'player_id',
        'hash',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function getExpirationDate(): Carbon
    {
        return $this->created_at->addDays(7);
    }

    public function getTimeToExpiration(): string
    {
        return $this->getExpirationDate()->to($this->created_at, null, false, 3);
    }

}
