<?php

namespace App\Domain\Player;

class PlayerService
{
    /**
     * Create or return existed user with provided credentials.
     *
     * @param array $payload
     *
     * @return Player
     * @see CreatePlayerRequest
     */
    public function createPlayer(array $payload): Player
    {
        return Player::firstOrCreate($payload);
    }

}
