<?php

namespace App\Domain\Player;

class PlayerService
{
    public function createPlayer(array $payload): Player
    {
        return Player::firstOrCreate($payload);
    }

}
