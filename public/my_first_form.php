<!DOCTYPE html>
<html>
<head>
	<title>forms</title>
</head>
<body>
	<?php
		print_r($_GET);
		echo "<br>";
		print_r($_POST);
		echo "<hr>";

	?>
	<h2>User Login:</h2>
	<form method="POST">
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
			<label>Betty<input type="radio" name="q1" value="betty"></label>
			<br><label>Lilly<input type="radio" name="q1" value="lilly"></label>
			<br><label>Kelly<input type="radio" name="q1" value="kelly"></label>
			<br><label>Mary<input type="radio" name="q1" value="mary"></label>
		
		<p>Who is Harry Potter's father?</p>
			<label>Jeremy<input type="radio" name="q2" value="jeremy"></label>
			<br><label>Jake<input type="radio" name="q2" value="jake"></label>
			<br><label>James<input type="radio" name="q2" value="james"></label>
			<br><label>Jimmy<input type="radio" name="q2" value="jimmy"></label>

		<p>

		<p>What are the four houses at Hogwarts?</p>
			<label>Gryffindor<input type="checkbox" name="q3[]" value="gryffindor"></label>
			<br><label>Winterfell<input type="checkbox" name="q3[]" value="winterfell"></label>
			<br><label>Mordor<input type="checkbox" name="q3[]" value="mordor"></label>
			<br><label>Slytherin<input type="checkbox" name="q3[]" value="slytherin"></label>
			<br><label>Ravenclaw<input type="checkbox" name="q3[]" value="ravenclaw"></label>
			<br><label>Baskerville<input type="checkbox" name="q3[]" value="baskerville"></label>
			<br><label>Hufflepuff<input type="checkbox" name="q3[]" value="hufflepuff"></label>

		<p>
			<input type="Submit">
		</p>
	</form>


</body>
</html>