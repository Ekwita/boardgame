<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Result;
use App\Models\Player;
use App\Repositories\GameRepository;
use App\Services\GameService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class GameController extends Controller
{

    protected $GameService;
    protected $GameRepository;

    public function __construct(GameService $GameService, GameRepository $GameRepository)
    {
        $this->GameService = $GameService;
        $this->GameRepository = $GameRepository;
    }

    /**
     * Rendering view of new game
     */
    public function index(): View
    {
        $players = $this->getPlayersList();
        return view('game.newgame', ['players' => $players]);
    }

    /**
     * Creating new game
     * Adding players to game
     * Insert game id & selected players to session.
     */
    public function newGame(Request $request): RedirectResponse
    {
        $gameId = $this->GameService->getNewGameId();
        $selectedPlayers = $this->getSelectedPlayers($request);

        $request->session()->put('game_id', $gameId);
        $request->session()->put('players', $selectedPlayers);

        return redirect()->route('counting');
    }

    /**
     * Rendering view of archived games
     */
    public function showGamesList(): View
    {
        $gameStatistics = $this->retrieveGameStatistics();

        if ($gameStatistics != null) {
            $games = $this->retrieveGames($gameStatistics);
            $winner = '';
            foreach ($games as $game) {
                $gameId = $game->id;
                $winner = $this->GameRepository->getWinner($gameId);
            }
            return view('game.gamelist', ['games' => $games, 'gameStatistics' => $gameStatistics, 'winner' => $winner]);
        } else {
            return view('game.gamelist', ['games' => null]);
        }
    }

    /**
     * 
     */
    private function getSelectedPlayers(Request $request): array
    {
        $selectedPlayers = [];


        for ($playerNumber = 1; $playerNumber <= 6; $playerNumber++) {
            $key = 'player' . $playerNumber;
            $inputValue = $request->input($key);

            if ($inputValue !== null) {
                $selectedPlayers[$key] = $inputValue;
            }
        }

        return $selectedPlayers;
    }

    /**
     * Getting the players list
     */
    private function getPlayersList(): Collection
    {
        return Player::pluck('player_name');
    }

    /**
     * Getting the finished games
     */
    private function retrieveGameStatistics(): Collection|null
    {
        $allGameIds = Game::pluck('id');
        if ($allGameIds->isEmpty()) {
            return null;
        } else {
            return Result::whereIn('game_id', $allGameIds)->get()->groupBy('game_id');
        }
    }

    /**
     * 
     */
    private function retrieveGames($gameStatistics): Paginator
    {
        $gameIds = $gameStatistics->keys();
        return Game::whereIn('id', $gameIds)->orderByDesc('id')->paginate(1);
    }
}
