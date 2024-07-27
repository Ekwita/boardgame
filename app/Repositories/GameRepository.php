<?php

namespace App\Repositories;

use App\Models\Game;
use Illuminate\Pagination\LengthAwarePaginator;

class GameRepository
{
    public function getWinner($gameId): string|null
    {
        $winner = Game::where('id', $gameId)->value('winner');

        return $winner;
    }

    public function playerStatisticsGame($gameIds): LengthAwarePaginator
    {
        return Game::whereIn('id', $gameIds)->orderByDesc('id')->paginate(1);
    }
}
