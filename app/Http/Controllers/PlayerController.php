<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Player;
use App\Repositories\GameRepository;
use App\Repositories\ResultRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function __construct(protected GameRepository $GameRepository, protected ResultRepository $ResultRepository)
    {}

    /**
     * Show list of all players
     */
    public function index(): View
    {
        $players = Player::all();
        return view('player.list', ['players' => $players]);
    }

    /**
     * Creating new player
     */
    public function newPlayer(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'player_name' => 'required|unique:players|max:30|regex:/^[a-zA-Z0-9]+$/'
        ]);

        $name = $request->input('player_name');

        Player::create([
            'player_name' => $name
        ]);

        return back();
    }

    /**
     * Show statistics for selected player
     */
    public function showPlayerStatistics(string $player): View
    {
        $data = Player::get()->where('player_name', $player)->first();

        return view('player.statistic', ['data' => $data]);
    }

    /**
     * List all games with selected player
     */
    public function showPlayerGames(string $player): View
    {
        $playerId = Player::where('player_name', $player)->pluck('id')->first();

        $gameIds = $this->ResultRepository->getGamesId($playerId);

        if ($gameIds != null) {
            $games = $this->GameRepository->playerStatisticsGame($gameIds);
            foreach ($games as $game) {
                $gameId = $game->id;
            }

            $winner = $this->GameRepository->getWinner($gameId);

            $playerStatistics = $this->getPlayersGamesList($gameIds);

            return view('game.gamelist', ['games' => $games, 'gameStatistics' => $playerStatistics, 'winner' => $winner]);
        } else {
            return view('game.gamelist', ['games' => null]);
        }
    }

    /**
     * 
     */
    private function getPlayersGamesList(SupportCollection $gameIds): Collection
    {
        $results = Result::whereIn('game_id', $gameIds)
            ->get()
            ->groupBy('game_id');

        return $results;
    }
}
