<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Player;
use App\Repositories\PlayerRepository;
use App\Repositories\ResultRepository;

class ResultService
{

    protected $ResultRepository;
    protected $PlayerService;
    protected $playerRepository;

    public function __construct(PlayerService $PlayerService, ResultRepository $ResultRepository, PlayerRepository $playerRepository)
    {
        $this->ResultRepository = $ResultRepository;
        $this->PlayerService = $PlayerService;
        $this->playerRepository = $playerRepository;
    }

    /**
     * Calculating result - service
     */
    public function calculateResult($request): void
    {
        $bestScore = 0;
        $bestArticaft = 0;

        $this->createGame();
        $this->processPlayers($request, $bestScore, $bestArticaft);
    }

    /**
     * Creating new game in database
     */
    protected function createGame()
    {
        return Game::create();
    }

    /** 
     * 
    */
    protected function processPlayers($request, $bestScore, $bestArticaft): void
    {
        $players = $request->session()->get('players'); // Players names
        $gameId = $request->session()->get('game_id'); // Game id

        $bestPlayer = '';
        foreach ($players as $player) {

            $playerId = Player::where('player_name', $player)->value('id');

            $status = $request->input('status_' . $player);

            $statusPoints = ($status == 3) ? 20 : 0;
            $playerBestArtifact = 0;
            $totalPoints = 0;
            if ($status != 1) {

                $gold = ($request->input('gold_' . $player) != null) ? $request->input('gold_' . $player) : 0;
                $tokens = $request->input('tokens_' . $player);
                $cards = $request->input('cards_' . $player);


                $totalArtifactsPoints = $this->calculateArtifactsPoints($player, $request, $playerBestArtifact);

                $totalPoints = $statusPoints + $totalArtifactsPoints + $gold + $tokens + $cards;

                $data = [
                    'player' => $player,
                    'status' => $status,
                    'gold' => $gold,
                    'tokens' => $tokens,
                    'cards' => $cards,
                    'totalPoints' => $totalPoints
                ];


                $this->ResultRepository->createGameResult($gameId, $playerId, $request, $data);

                $this->playerRepository->updatePlayerResult($request, $player, $gold);
            } else {
                $this->ResultRepository->createGameDeathResult($gameId, $playerId, $player, $status);

                $this->PlayerService->playerStatsIncrement($player);
            }

            if ($totalPoints > $bestScore || $totalPoints == $bestScore && $playerBestArtifact > $bestArticaft) {
                $bestScore = $totalPoints;
                $bestArticaft = $playerBestArtifact;
                $bestPlayer = $player;
            }
            if ($totalPoints > Player::where('player_name', $player)->value('best')) {
                Player::where('player_name', $player)->update(['best' => $totalPoints]);
            }
        }
        $this->updatePlayerStats($gameId, $bestPlayer);
    }

    /**
     * Calculating points from the artifacts
     */
    protected function calculateArtifactsPoints($player, $request, $playerBestArtifact): int
    {
        $artifacts = [
            'art5_' . $player => 5,
            'art7_' . $player => 7,
            'art10_' . $player => 10,
            'art12_' . $player => 12,
            'art15_' . $player => 15,
            'art17_' . $player => 17,
            'art20_' . $player => 20,
            'art25_' . $player => 25,
            'art30_' . $player => 30,
        ];

        $totalArtifactsPoints = 0;

        foreach ($artifacts as $artifactName => $artifactPoints) {
            if ($request->has($artifactName)) {
                $totalArtifactsPoints += $artifactPoints;
                if ($artifactPoints > $playerBestArtifact) {
                    $playerBestArtifact = $artifactPoints;
                }
            }
        }
        return $totalArtifactsPoints;
    }

/**
 * Update victory statistics for best player
 */
    protected function updatePlayerStats($gameId, $bestPlayer): void
    {
        if ($bestPlayer != null) {
            Game::where('id', $gameId)->update(['winner' => $bestPlayer]);
            Player::where('player_name', $bestPlayer)->increment('wins', 1);
        }
    }
}
