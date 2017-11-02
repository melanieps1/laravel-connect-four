<!DOCTYPE html>
<html>
<head>
	<title>Laravel Connect Four</title>

	<link rel="stylesheet" type="text/css" href="/style.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="https://use.fontawesome.com/e81701c933.js"></script>
</head>
<body class="container text-center">

	<h1 class="mt-5 mb-4">Laravel Connect Four</h1>

	<div class="row message">{{ message }}</div>

	<div class="row justify-content-center">
		<div class="drop">
			@if ($in_progress)
			<form method="get" action="/game/{{ $game_id }}/drop/0">
				<button class="btn btn-light ml-1 mr-1">
					<i class="fa fa-arrow-down {{ $currentPlayer }}Drop"></i>
				</button>
			</form>
			@else 
				<button class="btn btn-light ml-1 mr-1 disabled">
					<i class="fa fa-arrow-down"></i>
				</button>
			@endif
		</div>
		<div class="drop">
			@if ($in_progress)
			<form method="get" action="/game/{{ $game_id }}/drop/1">
				<button class="btn btn-light ml-1 mr-1">
					<i class="fa fa-arrow-down {{ $currentPlayer }}Drop"></i>
				</button>
			</form>
			@else 
				<button class="btn btn-light ml-1 mr-1 disabled">
					<i class="fa fa-arrow-down"></i>
				</button>
			@endif
		</div>
		<div class="drop">
			@if ($in_progress)
			<form method="get" action="/game/{{ $game_id }}/drop/2">
				<button class="btn btn-light ml-1 mr-1">
					<i class="fa fa-arrow-down {{ $currentPlayer }}Drop"></i>
				</button>
			</form>
			@else 
				<button class="btn btn-light ml-1 mr-1 disabled">
					<i class="fa fa-arrow-down"></i>
				</button>
			@endif
		</div>
		<div class="drop">
			@if ($in_progress)
			<form method="get" action="/game/{{ $game_id }}/drop/3">
				<button class="btn btn-light ml-1 mr-1">
					<i class="fa fa-arrow-down {{ $currentPlayer }}Drop"></i>
				</button>
			</form>
			@else 
				<button class="btn btn-light ml-1 mr-1 disabled">
					<i class="fa fa-arrow-down"></i>
				</button>
			@endif
		</div>
		<div class="drop">
			@if ($in_progress)
			<form method="get" action="/game/{{ $game_id }}/drop/4">
				<button class="btn btn-light ml-1 mr-1">
					<i class="fa fa-arrow-down {{ $currentPlayer }}Drop"></i>
				</button>
			</form>
			@else 
				<button class="btn btn-light ml-1 mr-1 disabled">
					<i class="fa fa-arrow-down"></i>
				</button>
			@endif
		</div>
		<div class="drop">
			@if ($in_progress)
			<form method="get" action="/game/{{ $game_id }}/drop/5">
				<button class="btn btn-light ml-1 mr-1">
					<i class="fa fa-arrow-down {{ $currentPlayer }}Drop"></i>
				</button>
			</form>
			@else 
				<button class="btn btn-light ml-1 mr-1 disabled">
					<i class="fa fa-arrow-down"></i>
				</button>
			@endif
		</div>
		<div class="drop">
			@if ($in_progress)
			<form method="get" action="/game/{{ $game_id }}/drop/6">
				<button class="btn btn-light ml-1 mr-1">
					<i class="fa fa-arrow-down {{ $currentPlayer }}Drop"></i>
				</button>
			</form>
			@else 
				<button class="btn btn-light ml-1 mr-1 disabled">
					<i class="fa fa-arrow-down"></i>
				</button>
			@endif
		</div>
	</div>

	<div class="mt-3 mb-3 board">

		@for ($i = $rows - 1; $i >= 0; $i--)

		<div class="row justify-content-center">

			@for ($j = 0; $j < $columns; $j++)

				<div class="spot {{ $board[$i][$j] }}"></div>

			@endfor

		</div>

		@endfor

	</div>

	<div class="mt-3 mb-3">
		Current Player: {{ $currentPlayer }}
	</div>

	<div class="mt-3 mb-3">
		Turn: {{ $turn }}
	</div>

	<div class="mt-3 mb-3">
		<form method="get" action="/restart">
			<button class="btn btn-primary">Start New Game</button>
		</form>
	</div>

</body>
</html>