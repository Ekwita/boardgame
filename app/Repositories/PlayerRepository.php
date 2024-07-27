<?php

namespace App\Repositories;

use App\Models\Player;

class PlayerRepository
{
    public function updatePlayerResult($request, $player, $gold): void
    {
        $playerToUpdate = Player::where('player_name', $player);
        $playerToUpdate->incrementEach([
            'games' => 1,
            'totalgold' => $gold,
            'art5' => $request->has('art5_' . $player) ? 1 : 0,
            'art7' => $request->has('art7_' . $player) ? 1 : 0,
            'art10' => $request->has('art10_' . $player) ? 1 : 0,
            'art12' => $request->has('art12_' . $player) ? 1 : 0,
            'art15' => $request->has('art15_' . $player) ? 1 : 0,
            'art17' => $request->has('art17_' . $player) ? 1 : 0,
            'art20' => $request->has('art20_' . $player) ? 1 : 0,
            'art25' => $request->has('art25_' . $player) ? 1 : 0,
            'art30' => $request->has('art30_' . $player) ? 1 : 0,
        ]);
    }
}
