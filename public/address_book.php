<?
//some fixed values for our address book

class AddressDataStore {

	//declare class attributes
    public $filename = '';
    public $addresses_array = [];

    //method to read from address book
    public function read_address_book() {
        //open the file for reading
        $read = fopen($this->filename, 'r');
        //while not at the end of file, add each contact to the array
		while(!feof($read)) {
			$contact = fgetcsv($read);
			//only if it is an array
			if(is_array($contact)) {
				$this->addresses_array[] = $contact;
			}
		}
		//close the handle
		fclose($read);
    }
    //method to write to address book
    public function write_address_book() {
        //open the file for writing
		$write = fopen($this->filename, 'w');
		//write contact to the file
		foreach ($this->addresses_array as $address) {
			fputcsv($write, $address);
		}
		//close the handle
		fclose($write);
    }

}

//create an instance
$address_book = new AddressDataStore();
//assign filename
$address_book->filename = 'address_book.csv';
//upload file
$address_book->read_address_book();

//arbitrary variable to check if form input was valid
$isValid = false;
//check to see if all the required fields were filled out
if(!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
	//required fields were filled out
	$isValid = true;
	//create new address to add
	$new_address = $_POST;
	//add new address
	$address_book->addresses_array[] = $new_address;
	//save addresses if new one added
	$address_book->write_address_book();
}

//remove items if we get an index to remove
if(isset($_GET['remove_item'])) {
	//remove the specified index
	unset($address_book->addresses_array[$_GET['remove_item']]);
	//save address book after removal
	$address_book->write_address_book();
	//refresh page
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

	<!--here is our address book loop -->
	<table border='1'>
		<tr><th>Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Phone#</th><th>Remove</th></tr>
		<? if(!empty($address_book->addresses_array)) : ?>
			<? foreach($address_book->addresses_array as $key=> $contact) : ?>
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
	<? if((!$isValid) && !empty($_POST)) : ?>
		<h3 style="color:red">You must input all required fields. </h3>
	<? endif; ?>
	<!--'sticky' form-->
	<form method="POST" action="address_book.php">
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
