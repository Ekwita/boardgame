<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepository;
use App\Repositories\ResultRepository;
use App\Services\ResultService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultController extends Controller
{

    protected $ResultService;
    protected $ResultRepository;
    protected $GameRepository;
    public function __construct(ResultService $ResultService, ResultRepository $ResultRepository, GameRepository $GameRepository)
    {
        $this->ResultService = $ResultService;
        $this->ResultRepository = $ResultRepository;
        $this->GameRepository = $GameRepository;
    }

    /**
     * Rendering of a view with a form for entering player points
     */
    public function countingView(Request $request): View
    {
        $players = $request->session()->get('players');

        return view('game.points', ['players' => $players]);
    }

    /**
     * Calculating result for all players in the game
     */
    public function calculate(Request $request): View
    {
        // $players = $request->session()->get('players');
        $gameId = $request->session()->get('game_id');

        $this->ResultService->calculateResult($request);

        $results = $this->ResultRepository->getResultsByGameId($gameId);
        $winner = $this->GameRepository->getWinner($gameId);

        $request->session()->flush();
        return view('game.result', ['results' => $results, 'winner' => $winner]);
    }
}
