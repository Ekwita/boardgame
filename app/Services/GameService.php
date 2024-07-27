<?php

namespace App\Services;

use App\Models\Game;

class GameService
{

    public function getNewGameId(): int
    {
        $lastGameId = $this->latestGameId();
        $newGameId = $lastGameId + 1;

        return $newGameId;
    }
    private function latestGameId(): int
    {
        $latestGame = Game::latest()->first();
        $lastGameId = $latestGame ? $latestGame->id : 0;


        return $lastGameId;
    }
}
