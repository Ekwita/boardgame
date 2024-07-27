<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\PlayerRepository;

class PlayerService
{
    public function __construct(protected PlayerRepository $playerRepository)
    {}
    public function updatePlayer($request, $player, $gold): void
    {
        $player = Player::where('player_name', $player);
        $this->playerRepository->updatePlayerResult($request, $player, $gold);
    }

    public function playerStatsIncrement($player): void
    {
        Player::where('player_name', $player)->incrementEach([
            'games' => 1,
            'deaths' => 1,
        ]);
    }
}
