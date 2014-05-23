<!DOCTYPE html>
<html>
<head>
	<title>forms</title>
</head>
<body>
	<?php
		var_dump($_GET);
		var_dump($_POST);

	?>
	<h2>User Login:</h2>
	<form method="GET" action="my_first_form.php">
    	<p>
    	    <label for="username">Username</label>
    	    <input id="username" name="username" type="text" placeholder="UserName" autofocus>
    	</p>
    	<p>
    	    <label for="password">Password</label>
    	    <input id="password" name="password" type="password" placeholder="Password">
    	</p>
    	<p>
    	    <input value="Log In" type="submit">
    	</p>
	</form>

	<h2>Compose an Email:</h2>
	<form method="POST">
		<p>
			<label for="to">To:</label>
			<textarea name="To" id="to" rows="1" cols="50"></textarea>
		</p>
		<p>
			<label for="from">From:</label>
			<textarea name="From" id="from" rows="1" cols="50"></textarea>
		</p>	
		<p>
			<label for="subject">Subject:</label>
			<textarea name="Subject" id="subject" rows="1" cols="50"></textarea>
		</p>
		<p>
			<textarea name="Body" id="Body" rows="20" cols="70" placeholder="type email here"></textarea>
		</p>
		<p>
    	    <label>Save a draft? <input value="save" name="draft" type="checkbox" checked></label>
    	</p>
		<p>
    	    <input value="Send" type="submit">
    	</p>
	</form>

	<h2>Multiple Choice Test</h2>

	<form method="POST">
		<p>Who is Harry Potter's mother?</p>
			<label for="q1a">Betty<input type="radio" id="q1a" name="q1" value="betty"></label>
			<br><label for="q1b">Lilly<input type="radio" name="q1" id="q1b" value="lilly"></label>
			<br><label for="q1c">Kelly<input type="radio" name="q1" id="q1c" value="kelly"></label>
			<br><label for="q1d">Mary<input type="radio" name="q1" id="q1d" value="mary"></label>
		
		<p>Who is Harry Potter's father?</p>
			<label for="q2a">Jeremy<input type="radio" name="q2" id="q2a" value="jeremy"></label>
			<br><label for="q2b">Jake<input type="radio" name="q2" id="q2b" value="jake"></label>
			<br><label for="q2c">James<input type="radio" name="q2" id="q2c" value="james"></label>
			<br><label for="q2d">Jimmy<input type="radio" name="q2" id="q2d" value="jimmy"></label>


		<p>What are the four houses at Hogwarts?</p>
			<label for="q3a">Gryffindor<input type="checkbox" id="q3a" name="q3[]" value="gryffindor"></label>
			<br><label for="q3b">Winterfell<input type="checkbox" id="q3b" name="q3[]" value="winterfell"></label>
			<br><label for="q3c">Mordor<input type="checkbox" id="q3c" name="q3[]" value="mordor"></label>
			<br><label for="q3d">Slytherin<input type="checkbox" id="q3d" name="q3[]" value="slytherin"></label>
			<br><label for="q3e">Ravenclaw<input type="checkbox" id="q3e" name="q3[]" value="ravenclaw"></label>
			<br><label for="q3f">Baskerville<input type="checkbox" id="q3f" name="q3[]" value="baskerville"></label>
			<br><label for="q3g">Hufflepuff<input type="checkbox" id="q3g" name="q3[]" value="hufflepuff"></label><br>


		<label for="quidditch">What are the balls in quidditch?</label>
			<select id="quidditch" name="quidditch[]" multiple>
				<option value="snitch">Snitch</option>
				<option value="twitch">Twitch</option>
				<option value="banger">Banger</option>
				<option value="quaffle">Quaffle</option>
				<option value="bludger">Bludger</option>
				<option value="falaffel">Falaffel</option>
			</select>

		<h2>Select Testing</h2>

		<label for="yesorno">Have you read Harry Potter?</label>
		<select id="yesorno" name="HP">
			<option value="1">Yes</option>
			<option value="0" selected>No</option>
		</select>

		<p>
			<input type="Submit">
		</p>

	</form>


</body>
</html>