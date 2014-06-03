<?
function csv_out($book, $file = 'address_book.csv') {
	//open the file
	$write = fopen($file, 'w');
	//write each contact to the file
	foreach ($book as $contact) {
		fputcsv($write, $contact);
	}
	//close the handle
	fclose($write);
}
//some fixed values for our address book
$address_book = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
];
//arbitrary variable to check if form input was valid
$isValid = false;
//check to see if all the required fields were filled out
if(!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
	$isValid = true;
	if(!empty($_POST['phone'])) {
		$new_address = $_POST;
		$address_book[] = $new_address;
	} else {
		//if they didnt put the phone field, get rid of the empty string
		array_pop($_POST);
		$new_address = $_POST;
		$address_book[] = $new_address;
	}
}
//write to the address book
if($isValid) {
	csv_out($address_book);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Address Book Writer</title>
</head>
<body>

	<h1>Address Book</h1>

	<!--here is our address book loop -->
	<table style='border: 1px solid black'>
		<tr><th>Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Phone#</th></tr>
		<? if(!empty($address_book)) : ?>
			<? foreach($address_book as $contact) : ?>
				<tr>
					<?foreach($contact as $info) : ?>
						<td style='border: 1px solid black'><?= $info ?></td>
					<? endforeach; ?>
				</tr>
			<? endforeach; ?>
		<? endif; ?>
	</table>


	<h3>Add Contacts</h3>
	
	<!--only show error message if form input is not valid-->
	<? if((!$isValid) && !empty($_POST)) : ?>
		<h3 style="color:red">You must input all required fields. </h3>
	<? endif; ?>
	<!--'sticky' form-->
	<form method="POST">
		<p>
			<label for="name">Name:</label>
			<input id="name" type="text" name="name" value="<?= (!$isValid && !empty($_POST['name'])) ? $_POST['name'] : '' ?>">
		</p>
		<p>
			<label for="address">Address:</label>
			<input id="address" type="text" name="address" value="<?= (!$isValid && !empty($_POST['address'])) ? $_POST['address'] : '' ?>">
		</p>
		<p>
			<label for="city">City:</label>
			<input id="city" type="text" name="city" value="<?= (!$isValid && !empty($_POST['city'])) ? $_POST['city'] : '' ?>">
		</p>
		<p>
			<label for="state">State:</label>
			<input id="state" type="text" name="state" value="<?= (!$isValid && !empty($_POST['state'])) ? $_POST['state'] : '' ?>">
		</p>
		<p>
			<label for="zip">Zip:</label>
			<input id="zip" type="text" name="zip" value="<?= (!$isValid && !empty($_POST['zip'])) ? $_POST['zip'] : '' ?>">
		</p>
		<p>
			<label for="phone">Phone:</label>
			<input id="phone" type="text" name="phone" value="<?= (!$isValid && !empty($_POST['phone'])) ? $_POST['phone'] : '' ?>">
		</p>
		
		<input type='submit' value="Add Contact">

	</form>

</body>
</html>