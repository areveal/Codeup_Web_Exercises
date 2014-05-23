<!DOCTYPE html>
<html>
<head>
	<title>forms</title>
</head>
<body>
	<?php
		print_r($_GET);
	?>
	<br>
	<?php
		print_r($_POST);
	?>

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

</body>
</html>