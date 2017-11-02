<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{

	public function drop($id, $column) {

		// error_log("In the drop function!");

		// (for initial testing) return "Dropped a checker in column " . $column . " for game " . $id;

		// Get the current game
		$game = \App\Game::find($id);
		$board = json_decode($game->board);

		// return $board;
		// die;

		// Put checker in column
		$placed_checker = false;
		for ($i = 0; $i < $game->rows; $i++) {
			if ($board[$i][$column] === '') {
				// If the row that we want in that column is currently unoccupied, then we will fill that spot with the color of player whose turn it is
				$board[$i][$column] = $game->players[$game->turn % 2];
				$placed_checker = true;
				break;
			}
		}

		if ($placed_checker) {

			// Did anyone win?
			$isWon = $this->checkBoard($board);
			if ($isWon) {

				$game->message = $game->players[$game->turn % 2] . " won!";
				
				// in_progress = false
				$game->in_progress = false;
			
			} if ($game->turn === 42) {
			
				// game is tied
				$game->in_progress = false;

				$game->message = 'Tie game!';
			
			}

			// Increment turn counter
			$game->turn++;
			$game->board = json_encode($board);

			// Save the game state
			$game->save();

		}

		// Show the board
		return redirect()->route('game', ['id' => $id]);
	}

	public function checkBoard($board) {
		
		// $board is a two-dimensional array

		// $wins is the set of lines on the board that represent wins
		$wins = [
			[ [0,0], [0,1], [0,2], [0,3] ],
      [ [1,0], [1,1], [1,2], [1,3] ],
      [ [2,0], [2,1], [2,2], [2,3] ],
      [ [3,0], [3,1], [3,2], [3,3] ],
      [ [4,0], [4,1], [4,2], [4,3] ],
      [ [5,0], [5,1], [5,2], [5,3] ],
      [ [0,1], [0,2], [0,3], [0,4] ],
      [ [1,1], [1,2], [1,3], [1,4] ],
      [ [2,1], [2,2], [2,3], [2,4] ],
      [ [3,1], [3,2], [3,3], [3,4] ],
      [ [4,1], [4,2], [4,3], [4,4] ],
      [ [5,1], [5,2], [5,3], [5,4] ],
      [ [0,2], [0,3], [0,4], [0,5] ],
      [ [1,2], [1,3], [1,4], [1,5] ],
      [ [2,2], [2,3], [2,4], [2,5] ],
      [ [3,2], [3,3], [3,4], [3,5] ],
      [ [4,2], [4,3], [4,4], [4,5] ],
      [ [5,2], [5,3], [5,4], [5,5] ],
      [ [0,3], [0,4], [0,5], [0,6] ],
      [ [1,3], [1,4], [1,5], [1,6] ],
      [ [2,3], [2,4], [2,5], [2,6] ],
      [ [3,3], [3,4], [3,5], [3,6] ],
      [ [4,3], [4,4], [4,5], [4,6] ],
      [ [5,3], [5,4], [5,5], [5,6] ],
      [ [0,0], [1,0], [2,0], [3,0] ],
      [ [0,1], [1,1], [2,1], [3,1] ],
      [ [0,2], [1,2], [2,2], [3,2] ],
      [ [0,3], [1,3], [2,3], [3,3] ],
      [ [0,4], [1,4], [2,4], [3,4] ],
      [ [0,5], [1,5], [2,5], [3,5] ],
      [ [0,6], [1,6], [2,6], [3,6] ],
      [ [1,0], [2,0], [3,0], [4,0] ],
      [ [1,1], [2,1], [3,1], [4,1] ],
      [ [1,2], [2,2], [3,2], [4,2] ],
      [ [1,3], [2,3], [3,3], [4,3] ],
      [ [1,4], [2,4], [3,4], [4,4] ],
      [ [1,5], [2,5], [3,5], [4,5] ],
      [ [1,6], [2,6], [3,6], [4,6] ],
      [ [2,0], [3,0], [4,0], [5,0] ],
      [ [2,1], [3,1], [4,1], [5,1] ],
      [ [2,2], [3,2], [4,2], [5,2] ],
      [ [2,3], [3,3], [4,3], [5,3] ],
      [ [2,4], [3,4], [4,4], [5,4] ],
      [ [2,5], [3,5], [4,5], [5,5] ],
      [ [2,6], [3,6], [4,6], [5,6] ],
      [ [3,0], [2,1], [1,2], [0,3] ],
      [ [3,1], [2,2], [1,3], [0,4] ],
      [ [3,2], [2,3], [1,4], [0,5] ],
      [ [3,3], [2,4], [1,5], [0,6] ],
      [ [4,0], [3,1], [2,2], [1,3] ],
      [ [4,1], [3,2], [2,3], [1,4] ],
      [ [4,2], [3,3], [2,4], [1,5] ],
      [ [4,3], [3,4], [2,5], [1,6] ],
      [ [5,0], [4,1], [3,2], [2,3] ],
      [ [5,1], [4,2], [3,3], [2,4] ],
      [ [5,2], [4,3], [3,4], [2,5] ],
      [ [5,3], [4,4], [3,5], [2,6] ],
      [ [0,0], [1,1], [2,2], [3,3] ],
      [ [0,1], [1,2], [2,3], [3,4] ],
      [ [0,2], [1,3], [2,4], [3,5] ],
      [ [0,3], [1,4], [2,5], [3,6] ],
      [ [1,0], [2,1], [3,2], [4,3] ],
      [ [1,1], [2,2], [3,3], [4,4] ],
      [ [1,2], [2,3], [3,4], [4,5] ],
      [ [1,3], [2,4], [3,5], [4,6] ],
      [ [2,0], [3,1], [4,2], [5,3] ],
      [ [2,1], [3,2], [4,3], [5,4] ],
      [ [2,2], [3,3], [4,4], [5,5] ],
      [ [2,3], [3,4], [4,5], [5,6] ]
		];

		$game_over = false;

		for ($i = 0; $i < count($wins) && !$game_over; $i++) {
			// $wins[$i] = an array of coordinates
			// error_log("Checking...\$wins[" . $i . "]"));
			// error_log(print_r($wins[$i], true));

			$game_over = $this->compareLine(
				$board[ $wins[$i][0][0] ][ $wins[$i][0][1] ],
				$board[ $wins[$i][1][0] ][ $wins[$i][1][1] ],
				$board[ $wins[$i][2][0] ][ $wins[$i][2][1] ],
				$board[ $wins[$i][3][0] ][ $wins[$i][3][1] ]
			);

			error_log("Is the game over?? $game_over");

		}

		return $game_over;

	}

	private function compareLine($a, $b, $c, $d) {

		error_log("Checking...$a, $b, $c, $d");

		return $a !== '' && $a === $b && $a === $c && $a === $d;
	}

	public function game($id) {

		$game = \App\Game::find($id);
		
		$game_id = $id;
		$turn = $game->turn;
		$rows = $game->rows;
		$columns = $game->columns;
		$board = json_decode($game->board);
		$in_progress = $game->in_progress;
		$message = $game->message;

		$currentPlayer = $game->players[$turn % 2];

		return view('board', compact('game_id', 'currentPlayer', 'turn', 'board', 'rows', 'columns', 'in_progress', 'message'));

		// Can be seen by going to http://localhost:8000/game/2
		// return "Working on game " . $id;

	}

	public function restart() {

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
	}

}