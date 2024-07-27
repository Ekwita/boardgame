<?php

namespace App\Repositories;

use App\Models\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;

class ResultRepository
{
    /**
     * Creating new records in Result database if player status is not 'Dead'
     * Saving data for player
     */
    public function createGameResult(int $gameId, int $playerId, Request $request, $data): void
    {
        Result::create([
            'game_id' => $gameId,
            'player_id' => $playerId,
            'player_name' => $data['player'],
            'status' => $data['status'],
            'art5' => $request->has('art5_' . $data['player']),
            'art7' => $request->has('art7_' . $data['player']),
            'art10' => $request->has('art10_' . $data['player']),
            'art12' => $request->has('art12_' . $data['player']),
            'art15' => $request->has('art15_' . $data['player']),
            'art17' => $request->has('art17_' . $data['player']),
            'art20' => $request->has('art20_' . $data['player']),
            'art25' => $request->has('art25_' . $data['player']),
            'art30' => $request->has('art30_' . $data['player']),
            'gold' => $data['gold'],
            'tokens' => $data['tokens'],
            'cards' => $data['cards'],
            'total_points' => $data['totalPoints'],
        ]);
    }

    /**
     * Creating new record in Result database if player status is 'Dead'
     * Saving data for player
     */
    public function createGameDeathResult(int $gameId, int $playerId, string $player, int $status): void
    {
        Result::create([
            'game_id' => $gameId,
            'player_id' => $playerId,
            'player_name' => $player,
            'status' => $status,
            'total_points' => '0',
        ]);
    }

    /**
     * Get game results by game ID, ordered by total points and artifact possession
     */
    public function getResultsByGameId(int $gameId): Collection
    {
        return Result::where('game_id', $gameId)
            ->orderByDesc('total_points')
            ->orderByDesc('art30')
            ->orderByDesc('art25')
            ->orderByDesc('art20')
            ->orderByDesc('art17')
            ->orderByDesc('art15')
            ->orderByDesc('art12')
            ->orderByDesc('art10')
            ->orderByDesc('art7')
            ->orderByDesc('art5')
            ->get();
    }

    public function getGamesId(int $playerId): SupportCollection|null
    {
        $gameIds = Result::where('player_id', $playerId)->pluck('game_id');
        if ($gameIds->isEmpty()) {
            return null;
        }
        return $gameIds;
    }
}
