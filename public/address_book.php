<?

function wrtite_csv($file, $book = '$address_book') {
	//open the file
	$write = fopen($file, 'w');
	//write each contact to the file
	foreach ($book as $contact) {
		fputcsv($write, $contact);
	}
	//close the handle
	fclose($write);
}

// function open_contacts($file = 'address_book.csv') {
// 	if(is_readable($file) && filesize($file) >0) {
// 		//open the file
// 		$read = fopen($file, 'r');
// 		//read it
// 		while(!feof($read)) {	
// 			$list[] = fgetcsv($read);
// 		}
// 		//close it
// 		fclose($read);


// 	} else {
// 		//file must be readable
// 		$list = [['File is not readable']];
// 	}
// 		return $list;

// }


$address_book = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
];

$address_book[] = $_POST;


$isValid = false;

if(!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
	$isValid = true;
}

if($isValid) {

	save_contacts('address_book.csv', $address_book);
	header('address_book.php');
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Address Book Writer</title>
</head>
<body>
	<h1>Address Book</h1>

	<table style="border:1px solid black">
		<tr><th>Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Phone#</th></tr>
		<? if(!empty($address_book)) : ?>
			<? foreach($address_book as $contact) : ?>
				<tr>
					<?foreach($contact as $info) : ?>
						<td><?= $info ?></td>
					<? endforeach; ?>
				</tr>
			<? endforeach; ?>
		<? endif; ?>
	</table>


	<h3>Add Contacts</h3>
	<? if((!$isValid) && !empty($_POST)) : ?>
		<h3 style="color:red">You must input all required fields. </h3>
	<? endif; ?>
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
			<input id="phone" type="text" name="phone">
		</p>
		<input type='submit' value="Add Contact">

	</form>

</body>
</html>