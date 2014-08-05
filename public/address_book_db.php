<?
var_dump($_POST);
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=address_book', 'cole', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


function getContacts($dbc) {
	
	$stmt = $dbc->query("SELECT p.name, a.address, a.city, a.state, a.zip, p.phone
						FROM addresses a
						JOIN people_add  pa ON a.id = pa.add_id
						JOIN people p ON p.id = pa.people_id");

	return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getExistingAddresses($dbc) {
	$stmt = $dbc->query("SELECT concat(a.address,' ',a.city,' ',a.state,' ',a.zip)
						FROM addresses a");

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$address_book = getContacts($dbc);
$existingAddresses = getExistingAddresses($dbc);

//arbitrary variable to check if form input was valid
$isValid = false;
//check to see if all the required fields were filled out
try{
	if(!empty($_POST['address_exists'])) {

	}

	if(!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
		//validate inputs
		foreach ($_POST as $value) {
            if (strlen($value) > 125) {
                throw new InvalidInputException("We're sorry. Your {$key} must be shorter than 125 characters.");
            }
        }
        echo "this works";
		$isValid = true;
		//create new address to add
		$query = "INSERT INTO people (name, phone) 
					VALUES (:name, :phone)";

		$stmt = $dbc->prepare($query);

		
	    $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
	    $stmt->bindValue(':phone', $_POST['phone'], PDO::PARAM_STR);

	    $stmt->execute();

	    $query = "INSERT INTO addresses (address, city, state, zip) 
					VALUES (:address, :city, :state, :zip)";

		$stmt = $dbc->prepare($query);

		
	    $stmt->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
	    $stmt->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
	    $stmt->bindValue(':state', $_POST['state'], PDO::PARAM_STR);
	    $stmt->bindValue(':zip', $_POST['zip'], PDO::PARAM_STR);

	    $stmt->execute();


		// $new_address = $_POST;
		//add new address
		// $address_book[] = $new_address;
	}
}catch(Exception $e){
	$msg = $e->getMessage();
}

//remove items if we get an index to remove
if(isset($_GET['remove_item'])) {
	//remove the specified index
	unset($address_book[$_GET['remove_item']]);
	//save address book after removal
	// $book->write_address_book($address_book);
	//reload page
	header('Location: address_book_db.php');

	exit(0);
}

// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file']['error'] == 0) {
	if($_FILES['file']['type'] == 'text/csv'){	
		// Set the destination directory for uploads
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		// Grab the filename from the uploaded file by using basename
		$filename = basename($_FILES['file']['name']);
		// Create the saved filename using the file's original name and our upload directory
		$saved_filename = $upload_dir . $filename;
		// Move the file from the temp location to our uploads directory
		move_uploaded_file($_FILES['file']['tmp_name'], $saved_filename);
		//time to import the list
		//add new items to todo list
		// $address_book = array_merge($address_book, $import_book);
	} else {
		//send error message if not a text file
		$errormessage = "File must be a csv file... You jive turkey!!!";		
	}

	//save to file
	// $book->write_address_book($address_book);

}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Address Book DB</title>
	
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
			<? foreach($address_book as $key => $contact) : ?>
				<tr>
					<?foreach($contact as $info) : ?>
						<td><?= $info ?></td>
					<? endforeach; ?>
					<td><a href=<?= "?remove_item=$key"?>>Remove Item</a></td>
				</tr>
			<? endforeach; ?>
		<? endif; ?>
	</table>



	<!--'sticky' form-->
	<form method="POST" action="address_book_db.php" class="form-horizontal">
		<h3>Add Contacts</h3>

		<!--only show error message if form input is not valid-->
		<? 
		 	if(isset($msg)) { 
				echo "<h2 style='color:red'>$msg</h2>"; 
		    }elseif((!$isValid) && !empty($_POST) && empty($_POST['file']) && empty($_POST['address_exists'])) { 
				echo "<h3 style=\"color:red\">You must input all required fields.</h3>";
		    } 
		?>

		<label for="name">Name:</label>
		<input class="form-horizontal" id="name" placeholder="Your Name" type="text" name="name" value="<?= (!$isValid && !empty($_POST['name'])) ? $_POST['name'] : '' ?>">

<!-- 		<h3>Choose Existing Address</h3>
		<select name="address_exists">
			<? foreach ($existingAddresses as $key => $address) : ?>
				<?foreach ($address as $info) : ?>
					<option value="<?=$key?>"><?=$info?></option>
				<? endforeach; ?>
			<? endforeach; ?>

		</select> -->

		<h3>Add New Address</h3>
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

<!-- 	</form>
	<h3>Import Address Book</h3>
	<form method="POST" action="address_book_db.php" enctype="multipart/form-data">
		<p><input type='file' name='file'></p>
		<input type='submit' value='Upload'>
	</form> -->

</body>
</html>