<!DOCTYPE html>
<html>
<head>
	<title>Laravel Connect Four</title>

	<link rel="stylesheet" type="text/css" href="style.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body class="container text-center">

	<h1 class="mt-5 mb-4">Laravel Connect Four</h1>

	<div class="row justify-content-center">
		<div class="drop"><button class="btn btn-light ml-1 mr-1">Drop!</button></div>
		<div class="drop"><button class="btn btn-light ml-1 mr-1">Drop!</button></div>
		<div class="drop"><button class="btn btn-light ml-1 mr-1">Drop!</button></div>
		<div class="drop"><button class="btn btn-light ml-1 mr-1">Drop!</button></div>
		<div class="drop"><button class="btn btn-light ml-1 mr-1">Drop!</button></div>
		<div class="drop"><button class="btn btn-light ml-1 mr-1">Drop!</button></div>
		<div class="drop"><button class="btn btn-light ml-1 mr-1">Drop!</button></div>
	</div>

	<div class="mt-3 mb-3 board">

		@for ($i = $rows - 1; $i >= 0; $i--)

		<div class="row">

			@for ($j = 0; $j < $columns; $j++)

				<div class="spot {{ $board[$i][$j] }}">{{ $i }}, {{ $j }}</div>

			@endfor

		</div>

		@endfor

	</div>

	<div class="mt-3 mb-3">
		Current Player: {{ $currentPlayer }}
	</div>

	<div class="mt-3 mb-3">
		<button class="btn btn-primary">Start New Game</button>
	</div>

</body>
</html>