<html>
<head>
	<title>Whack!</title>
	<script src="../js/jquery/jquery.js"></script>
	<script>
		$(document).ready(function() {

			var ouch = new Audio('http://www.tjande.com/sounds/youch2.wav');
			var laugh = new Audio('http://www.ihugh.co.nz/sounds/sounds/WoodyLaugh.wav');
			var cheer = new Audio('http://www.palmbeach.k12.fl.us/RooseveltMS/cavank/sounds/kids_cheer.wav');

			var theme = 'mole';

			var high_score = 0;

			var pop_up = function(place){
				if(theme == 'got'){
					$(place).html('<img src="../img/jeoffry.png" class="mole">');
					$('.mole').css('top','25px');
					$('.mole').css('left','45px');
				} else if(theme == 'mole') {
					$(place).html('<img src="../img/mole.png" class="mole">');
				}
			}

			var hide = function(place) {
				$('.mole').remove();
			}
			
			var play_game = function() {
				$('#box').show();
				if (theme == 'got') {
					$('body').css('cursor','url(../img/cup.png),auto');
				}else if (theme == 'mole'){
					$('body').css('cursor','url(../img/mallet.png),auto');
				}
				$('#show_timer').show();
				var score = 0;
				var level = 1;
				var hits = 0;
				$('#num_level').html(level);
				$('#level').fadeIn();
				$('#score').html(score);
				var time = 2000;
				var timer = 59;
				var timeId = setInterval(function(){
					$('#timer').html(timer);
					timer--;
				},1000);
				//every second pop up and hide for 10 seconds
				var gameId = setInterval(function(){
						var here_i_am = '#hole' + Math.ceil(Math.random()*10);
						pop_up(here_i_am);

						var popId = setTimeout(function(){
							hide(here_i_am);
							laugh.play();
						},(time*.85));
						
						$('.mole').click(function() {
							ouch.play();
							hits++;
							hide(here_i_am);
							//changes score based on level
							if (hits >= 20) {
								score +=100;
							} else if (hits >15) {
								score +=50;
							} else if (hits > 9) {
								score +=30;
							} else if (hits > 4) {
								score +=20;
							} else{
								score +=10;
							};

							$('#score').html(score);

							clearTimeout(popId);
							//level 2
							if(score == 40) {
								time = 1500;
								level = 2;
								$('#level').fadeToggle(250);
								$('#num_level').delay(250).html(level);
								$('#level').fadeToggle();
							} 
							//level 3
							else if (score == 140) {
								time = 1000;
								level = 3;
								$('#level').fadeToggle(250);
								$('#num_level').delay(250).html(level);
								$('#level').fadeToggle();
							} 
							//level 4
							else if (score == 320) {
								time = 750;
								level = 4;
								$('#level').fadeToggle(250);
								$('#num_level').delay(250).html(level);
								$('#level').fadeToggle();
							} 
							//final level
							else if (score == 820) {
								time = 500;
								level = ' Final';
								$('#level').fadeToggle(250);
								$('#num_level').delay(250).html(level);
								$('#level').fadeToggle();
							}
						});							
				},time);
				// stops game
				setTimeout(function(){
					clearTimeout(gameId);
					clearTimeout(timeId);
					$('body').css('cursor','auto');
					$('#box').hide();
					$('#show_timer').hide();
					$('#level').fadeOut();
					//flash game over
					var game_overId = setInterval(function(){
						$('#game_over').fadeToggle(500);
					},500);
					
					//clear the interval
					setTimeout(function(){
						clearTimeout(game_overId);
						$('#start').show();
						//checks high score
						if(score > high_score) {
							cheer.play();
							$('#new_high').fadeIn(2000);
							$('#new_high').fadeOut(2000);
							high_score = score;
							$('#high_score').html(high_score);
						}
					},5500);


				},60000);

			};

			$('#start').click(function(){
				$('#start').hide();
				$('#disclaimer').fadeIn(2000);
				$('#disclaimer').fadeOut(2000,function() {
				play_game();
					
				});
			});


			$('#easter_got').click(function(){
				theme = 'got';
				$('body').css('background-image',"url('../img/got_back.jpg')");
				$('body').children().css('color','#f22');
				$('#box').css('background-image',"url('../img/wood.jpg')");
				$('.hole').css('background-color','#000');
				$('#disclaimer').css('top','200px');
				$('#level').css('top','0px');
				$('#show_timer').css('top','220px');
				$('#disclaimer_theme').html('But Jeoffry might have been... <br>');
				$('#head_theme').html('Jeoffry');
				$('#new_high').css('top','60px');
				$('#game_over').css('top', '65px');
				$('#easter').remove();

			});	

			$('#go_codeup').click(function(){
				$('.regular_stuff').fadeOut();
				$('#hidden').fadeIn(3000).fadeOut(3000);
				$('.regular_stuff').delay(6000).fadeIn();
			});


		});
	</script>
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