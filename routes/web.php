<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

	return redirect()->route('restart');

  // Below line names the route!
})->name('board');


Route::get('/game/{id}/drop/{column}', function($id, $column) {

	// return "Dropped a checker in column " . $column . " for game " . $id;

	// Get the current game
	$game = \App\Game::find($id);
	$board = json_decode($game->board);

	// return $board;
	// die;

	// Put checker in column
	// TODO: Defaulting to row 0, needs to be fixed
	$board[0][$column] = $game->players[$game->turn % 2];

	// Did anyone win?

	// Increment turn counter
	$game->turn++;
	$game->board = json_encode($board);

	// Save the game state
	$game->save();

	// Show the board
	return redirect()->route('game', ['id' => $id]);

});


Route::get('game/{id}', function($id) {

	$game = \App\Game::find($id);
	
	$game_id = $id;
	$turn = $game->turn;
	$rows = $game->rows;
	$columns = $game->columns;
	$board = json_decode($game->board);

	$currentPlayer = $game->players[$turn % 2];

	return view('board', compact('game_id', 'currentPlayer', 'turn', 'board', 'rows', 'columns'));

	// Can be seen by going to http://localhost:8000/game/2
	// return "Working on game " . $id;

})->name('game');


Route::get('/restart', function() {

	// TODO: End the old game (set in_progress to false?) once we have user logins and user_ids

	// Make a new game (same Tinker commands)
	$game = new \App\Game;
	$game->turn = 1;
	$game->board = [];

	for ($r = 0; $r < $game->rows; $r++) {
		for ($c = 0; $c < $game->columns; $c++) {
			$board[$r][$c] = '';
		}
	}

	$game->board = json_encode($board);
	$game->save();

	$id = $game->id;

	// Show the board
	return redirect()->route('game', ['id' => $id]);

})->name('restart');
