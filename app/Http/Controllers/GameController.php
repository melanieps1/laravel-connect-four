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
				
				$game->in_progress = false;
			
			} if ($game->turn === 43) {
			
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

	public function compareLine($a, $b, $c, $d) {

		// error_log("Checking $a, $b, $c, $d");

		if (($a !== 0) && ($a === $b) && ($a === $c) && ($a === $d)) {
			$isWon = true;
		}
	}

	public function checkBoard($board) {
		
		$isWon = false;

		// Check down
		if ($isWon = false) {
			for ($r = 0; $r < 3; $r++) {
				for ($c = 0; $c < 7; $c++) {
					if ($this->compareLine($board[$r][$c], $board[$r+1][$c], $board[$r+2][$c], $board[$r+3][$c])) {
						// return $board[$r][$c];
						error_log("Check down $game_over");
	        	$isWon = true;
					}
				}
			}
		}

    // Check right
    else if ($isWon = false) {
	    for ($r = 0; $r < 6; $r++) {
	      for ($c = 0; $c < 4; $c++) {
	        if (compareLine($board[$r][$c], $board[$r][$c+1], $board[$r][$c+2], $board[$r][$c+3])) {
	        	// return $board[$r][$c];
	        	error_log("Check right $game_over");
	        	$isWon = true;
	        }
	      }
	    }
    }

    // Check down-right
    else if ($isWon = false) {
	    for ($r = 0; $r < 3; $r++) {
	      for ($c = 0; $c < 4; $c++) {
	        if (compareLine($board[$r][$c], $board[$r+1][$c+1], $board[$r+2][$c+2], $board[$r+3][$c+3])) {
	          // return $board[$r][$c];
	          error_log("Check down right $game_over");
	        	$isWon = true;
	      	}
	    	}
	  	}
  	}

    // Check down-left
    else if ($isWon = false) {
	    for ($r = 3; $r < 6; $r++) {
	      for ($c = 0; $c < 4; $c++) {
	        if (compareLine($board[$r][$c], $board[$r-1][$c+1], $board[$r-2][$c+2], $board[$r-3][$c+3])) {
	          // return $board[$r][$c];
	          error_log("Check down left $game_over");
	        	$isWon = true;
	      	}
	    	}
	  	}
	  }

   else {
   	$isWon = false;
   }

		error_log("Is the game over? $isWon");

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