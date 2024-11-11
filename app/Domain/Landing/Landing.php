<?php

namespace App\Domain\Landing;

use App\Domain\Player\Player;
use App\Domain\Spin\History\LandingObserver as SpinLandingObserver;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * Simple model for landing page that uses soft deletes to prevent players from visiting the page, but allow to get
 * some statistics on the backend. Observer here used to show some event-driven logic. Observer will put model in
 * cache withing every model's state change.
 */
#[ObservedBy([
    LandingObserver::class,
    SpinLandingObserver::class,
])]
class Landing extends Model
{
    use SoftDeletes;

    protected static int $expiration;

    public string $playerName;

    protected $fillable = [
        'player_id',
        'hash',
    ];

    /**
     * Funny, but I've set this directly to prevent establishing database connection during spins )))
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    public static function newFromDto(LandingDto $dto): self
    {
        $data       = $dto->toArray();
        $attributes = Arr::only($data, [
            'id',
            'player_id',
            'hash',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);

        return (new self())
            ->newInstance([], Arr::has($attributes, 'id'))
            ->setRawAttributes($attributes, true)
            ->setPlayerName(Arr::get($data, 'player_name'));
    }

    protected static function boot()
    {
        parent::boot();

        // Save expiration limit value in static property to prevent redundant calls to config() helper
        static::$expiration = config('domain.landing_expiration');
    }

    public function getPlayerName(): string
    {
        return $this->playerName ?? $this->player->name;
    }

    public function setPlayerName(?string $name): self
    {
        $this->playerName = $name;

        return $this;
    }

    public function toDto(): LandingDto
    {
        $attributes = $this->getAttributes();

        $attributes['player_name'] = $this->getPlayerName();

        return new LandingDto($attributes);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * @return Carbon
     */
    public function getExpirationDate(): Carbon
    {
        return $this->created_at->clone()->addDays(static::$expiration);
    }

    public function getTimeToExpiration(): string
    {
        return now()->diffForHumans(
            $this->getExpirationDate(),
            CarbonInterface::DIFF_RELATIVE_TO_OTHER,
            false,
            3
        );
    }

    public function isActive(): bool
    {
        return $this->getExpirationDate()->isFuture();
    }

}
