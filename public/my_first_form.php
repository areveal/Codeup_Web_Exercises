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
    	    <input value="Send" type="submit">
    	</p>
	</form>

</body>
</html>