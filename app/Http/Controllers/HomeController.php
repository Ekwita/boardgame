<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Result;
use App\Repositories\GameRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(protected GameRepository $gameRepository)
    {
    }

    public function index(): View
    {
        session()->flush();
        $lastGame = Game::latest()->first();
        if ($lastGame !== null) {
            $gameId = $lastGame->id;
            $results = Result::where('game_id', $gameId)->get();
            return view('index', ['results' => $results, 'game' => $lastGame]);
        } else {
            return view('index');
        }
    }
}
