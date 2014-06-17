<html>
<head>
	<title>Whack!</title>
	<script src="../js/jquery/jquery.js"></script>
	<script src="whack.js"></script>
	<link rel="stylesheet" type="text/css" href="whack.css">
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

</head>

<body>
	<!--heading-->
	<h1 id="big_head" class="regular_stuff">Whack-A-<span id="head_theme">Mole</span></h1>
	<!--Disclaimer-->
	<h3 id="disclaimer">No moles were harmed in the making of this game.<br>
		<span id="disclaimer_theme"></span>
		Please do not attempt this at home.<br>
		We are professionals.</h3>
	<!--start button-->
	<button id="start" class="regular_stuff">Start</button>
	<!--show score and high score-->
	<span id="show_score" class="regular_stuff">Score: <span id="score">0</span></span>
	<span id="show_high" class="regular_stuff">High Score: <span id="high_score">0</span></span>

	<span id="show_timer">Timer: <span id="timer"></span></span>

	<!--game over-->
	<div id="game_over">
		<img src="../img/game_over.png" class="game_over">
	</div>
	<div id="new_high">
		<img src="../img/high_score.png" class="high_score">
	</div>
	<div id="level">
		<h2 id="what_level">Level <span id="num_level"></span></h2>
	</div>
	
	<!--here is our box of holes-->
	<div id="box">	
		<div class="hole" id="hole1"></div>
		<div class="hole" id="hole2"></div>
		<div class="hole" id="hole3"></div>
		<div class="hole" id="hole4"></div>
		<div class="hole" id="hole5"></div>
		<div class="hole" id="hole6"></div>
		<div class="hole" id="hole7"></div>
		<div class="hole" id="hole8"></div>
		<div class="hole" id="hole9"></div>
		<div class="hole" id="hole10"></div>
	</div>

	<div id="easter_got"></div>
	<div id="go_codeup"></div>
	<h1 id="hidden">GO CODEUP</h1>
</body>
</html>