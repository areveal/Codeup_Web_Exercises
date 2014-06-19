<?

//address book class import
require_once('classes/address_data_store.php');

//create an instance
$book = new AddressDataStore('address_book.csv');
//upload file
$address_book = $book->read_address_book();

//arbitrary variable to check if form input was valid
$isValid = false;
//check to see if all the required fields were filled out
if(!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
	//required fields were filled out
	$isValid = true;
	//create new address to add
	$new_address = $_POST;
	//add new address
	$address_book[] = $new_address;
	//save addresses if new one added
	$book->write_address_book($address_book);

}

//remove items if we get an index to remove
if(isset($_GET['remove_item'])) {
	//remove the specified index
	unset($address_book[$_GET['remove_item']]);
	//save address book after removal
	$book->write_address_book($address_book);
	//reload page
	header('Location: address_book.php');

	exit(0);
}

// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file']['error'] == 0) {
	if($_FILES['file']['type'] == 'text/csv'){	
		// Set the destination directory for uploads
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		// Grab the filename from the uploaded file by using basename
		$filename = basename($_FILES['file']['name'] . time());
		// Create the saved filename using the file's original name and our upload directory
		$saved_filename = $upload_dir . $filename;
		// Move the file from the temp location to our uploads directory
		move_uploaded_file($_FILES['file']['tmp_name'], $saved_filename);
		//time to import the list
		//create a new instance for your imported list
		$import = new AddressDataStore("uploads/$filename");
		//read in file	
		$import_book = $import->read_address_book();
		//add new items to todo list
		$address_book = array_merge($address_book, $import_book);
		//save
		$book->write_address_book($address_book);
	} else {
		//send error message if not a text file
		$errormessage = "File must be a csv file... You jive turkey!!!";		
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Address Book Writer</title>
	
	<!-- twitter bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	
	<!-- bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

</head>
<body>

	<h1>Address Book</h1>

	<!--here is our address book loop -->
	<table class="table table-hover">
		<tr><th>Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Phone#</th><th>Remove</th></tr>
		<? if(!empty($address_book)) : ?>
			<? foreach($address_book as $key=> $contact) : ?>
				<tr>
					<?foreach($contact as $info) : ?>
						<td><?= htmlspecialchars(htmlentities($info)) ?></td>
					<? endforeach; ?>
					<td><a href=<?= "?remove_item=$key"?>>Remove Item</a></td>
				</tr>
			<? endforeach; ?>
		<? endif; ?>
	</table>


	<h3>Add Contacts</h3>

	<!--only show error message if form input is not valid-->
	<? if((!$isValid) && !empty($_POST) && empty($_POST['file'])) : ?>
		<h3 style="color:red">You must input all required fields. </h3>
	<? endif; ?>
	<!--'sticky' form-->
	<form method="POST" action="address_book.php" class="form-horizontal">
		<p>
			<label for="name">Name:</label>
			<input class="form-horizontal" id="name" placeholder="Your Name" type="text" name="name" value="<?= (!$isValid && !empty($_POST['name'])) ? $_POST['name'] : '' ?>">
		</p>
		<p>
			<label for="address">Address:</label>
			<input class="form-horizontal" id="address" placeholder="Your Address" type="text" name="address" value="<?= (!$isValid && !empty($_POST['address'])) ? $_POST['address'] : '' ?>">
		</p>
		<p>
			<label for="city">City:</label>
			<input class="form-horizontal" id="city" placeholder="City" type="text" name="city" value="<?= (!$isValid && !empty($_POST['city'])) ? $_POST['city'] : '' ?>">
		</p>
		<p>
			<label for="state">State:</label>
			<input class="form-horizontal" id="state" placeholder="State" type="text" name="state" value="<?= (!$isValid && !empty($_POST['state'])) ? $_POST['state'] : '' ?>">
		</p>
		<p>
			<label for="zip">Zip:</label>
			<input class="form-horizontal" id="zip" placeholder="Zip Code" type="text" name="zip" value="<?= (!$isValid && !empty($_POST['zip'])) ? $_POST['zip'] : '' ?>">
		</p>
		<p>
			<label for="phone">Phone:</label>
			<input class="form-horizontal" id="phone" placeholder="Phone Number" type="text" name="phone" value="<?= (!$isValid && !empty($_POST['phone'])) ? $_POST['phone'] : '' ?>">
		</p>
		
		<input type='submit' value="Add Contact">

	</form>
	<h3>Import Address Book</h3>
	<form method="POST" action="address_book.php" enctype="multipart/form-data">
		<p><input type='file' name='file'></p>
		<input type='submit' value='Upload'>
	</form>

</body>
</html>
