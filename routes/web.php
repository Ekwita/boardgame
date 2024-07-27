<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::post('/language-switch', [LanguageController::class, 'languageSwitch'])->name('language.switch'); //Zmiana języka

Route::get('/', [HomeController::class, 'index'])->name('base'); //Widok strony głównej

Route::get('/newgame', [GameController::class, 'index'])->name('newGameView'); //Widok nowej gry
Route::post('/newgame', [GameController::class, 'newGame'])->name('playersSelect'); //Przesłanie danych o wybranych graczach do kontrolera

Route::middleware('checkSessionData')->group(function () {
    Route::get('/newgame/counting', [ResultController::class, 'countingView'])->name('counting'); //Wyświetlenie widoku do wpisywania punktów
    Route::post('/newgame/counting', [ResultController::class, 'calculate'])->name('calculate'); //Wysłanie danych o punktach do kontrolera i podliczenie punktów
});

Route::post('/new_player', [PlayerController::class, 'newPlayer'])->name('player.create'); //Tworzenie nowego gracza
Route::get('/players', [PlayerController::class, 'index'])->name('player.list'); // Wyświetlanie listy stworzonych graczy


Route::middleware('checkPlayerExists')->group(function () {
    Route::get('/players/{player}', [PlayerController::class, 'showPlayerStatistics'])->name('player.statistics'); //Wyświetlenie statystyk gracza
    Route::get('/players/{player}/games', [PlayerController::class, 'showPlayerGames'])->name('player.games'); //Wyświetlenie wszystkich gier gracza
});

Route::get('/game_list', [GameController::class, 'showGamesList'])->name('gamelist'); //Wyświetlanie listy wszystkich gier
