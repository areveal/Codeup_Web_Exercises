<?

$this_guy = $_GET['contact'];
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=address_book', 'cole', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function getContact($dbc) {
	$here = $_GET['contact'];

	$stmt = $dbc->query("SELECT p.name, p.id
						FROM people p 
						WHERE p.id = $here");

	return $stmt->fetchAll(PDO::FETCH_ASSOC);	

}

function getContactInfo($dbc) {

	$here = $_GET['contact'];

	$stmt = $dbc->query("SELECT p.name, p.id, pa.people_id, pa.add_id, concat(a.address, ' ', a.city, ' ', a.state, ' ', a.zip) address
						FROM people p 
						JOIN people_add pa ON p.id = pa.people_id
						JOIN addresses a ON pa.add_id = a.id
						WHERE p.id = $here");

	return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

$contact = getContact($dbc);
$address_book = getContactInfo($dbc);

function getExistingAddresses($dbc,$contact) {
	$this_guy = $contact[0]['id'];
	$stmt = $dbc->query("SELECT concat(a.address,' ',a.city,' ',a.state,' ',a.zip) address, a.id
						FROM addresses a
						ORDER BY a.address"); 

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//arbitrary variable to check if form input was valid
$isValid = false;
//check to see if all the required fields were filled out
try{
	if(!empty($_POST['address_exists'])) {
		$query = "INSERT INTO people_add (people_id, add_id) 
					VALUES (:people_id, :add_id)";

		$stmt = $dbc->prepare($query);
	    
	    $stmt->bindValue(':people_id', $this_guy, PDO::PARAM_STR);
	    $stmt->bindValue(':add_id', $_POST['address_exists'], PDO::PARAM_STR);

	    $stmt->execute();

	    header("Location:http://codeup.dev/contact-addresses.php?contact=$this_guy");
	    exit(0);
	}

	if(!empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
		//validate inputs
		foreach ($_POST as $value) {
            if (strlen($value) > 125) {
                throw new Exception("We're sorry. Your {$key} must be shorter than 125 characters.");
            }
        }
		$isValid = true;

	    $query = "INSERT INTO addresses (address, city, state, zip) 
					VALUES (:address, :city, :state, :zip)";

		$stmt = $dbc->prepare($query);

		
	    $stmt->bindValue(':address', $_POST['address'], PDO::PARAM_STR);
	    $stmt->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
	    $stmt->bindValue(':state', $_POST['state'], PDO::PARAM_STR);
	    $stmt->bindValue(':zip', $_POST['zip'], PDO::PARAM_STR);

	    $stmt->execute();

		$query = "SELECT max(id) FROM addresses";


		$stmt = $dbc->prepare($query);
	    $stmt->execute();

	    $thing = $stmt->fetch();
	    $thing = $thing[0];	 
 

		$query = "INSERT INTO people_add (people_id, add_id) 
					VALUES (:people_id, :add_id)";

		$stmt = $dbc->prepare($query);
	    
	    $stmt->bindValue(':people_id', $this_guy, PDO::PARAM_STR);
	    $stmt->bindValue(':add_id', $thing, PDO::PARAM_STR);

	    $stmt->execute();

	    header("Location:http://codeup.dev/contact-addresses.php?contact=$this_guy");
	    exit(0);

	}
}catch(Exception $e){
	$msg = $e->getMessage();
}

// //remove items if we get an index to remove
if(isset($_POST['remove'])) {
	$stmt = $dbc->prepare("DELETE FROM people_add WHERE add_id = :add_id AND people_id = :people_id");
	$stmt->bindValue(':add_id', $_POST['remove'], PDO::PARAM_STR);
	$stmt->bindValue(':people_id', $this_guy, PDO::PARAM_STR);
	$stmt->execute();

	header("Location: contact-addresses.php?contact=$this_guy");
	exit(0);
}
// if(isset($_GET['remove_item'])) {
// 	//remove the specified index
// 	unset($address_book[$_GET['remove_item']]);
// 	//save address book after removal
// 	// $book->write_address_book($address_book);
// 	//reload page
// 	header('Location: address_book_db.php');

// 	exit(0);
// }


$existingAddresses = getExistingAddresses($dbc, $contact);


?>

<!DOCTYPE html>
<html>
<head>
	
	<!--jquery-->	
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<!--jquery-->	
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<!-- twitter bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	
	<!-- bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


	<title>Contact Address DB</title>
	<style type="text/css">
		#home{
			position: absolute;
			top: 20px;
			right: 20px;
		}
		.btn-danger {
			position: relative;
			left: -40px;
		}
	</style>

</head>
<body>

	<h1><?=$contact[0]['name']?></h1>

	<!--here is our address book loop -->
	<table class="table table-striped">
		<tr><th>Address</th><th>Action</th></tr>
		<? if(!empty($address_book)) : ?>
			<? foreach($address_book as $key => $contact) : ?>
				<tr>
					<td><?=$contact['address']?></td>
					<td><button data-contact="<?=$contact['add_id']?>" class="btn btn-danger remove-me">Remove Contact</button></td>
				</tr>
			<? endforeach; ?>
		<? endif; ?>
	</table>
	<? 
	 	if(isset($msg)) { 
			echo "<h2 style='color:red'>$msg</h2>"; 
	    }elseif((!$isValid) && !empty($_POST) && empty($_POST['address_exists']) && empty($_POST['remove'])) { 
			echo "<h3 style=\"color:red\">You must input all required fields.</h3>";
	    } 
	?>

 <? if(isset($_GET['add_address'])) :
		if(isset($_GET['new'])) :
			if($_GET['new'] == 'true') : ?>
				<? //display new address form ?>
					<form method="POST" action="contact-addresses.php?contact=<?=$this_guy?>" class="form-horizontal">
						<h3>Add New Address</h3>
						
							<label for="address">Address:</label>
							<input class="form-horizontal" id="address" placeholder="Your Address" type="text" name="address" value="<?= (!$isValid && !empty($_POST['address'])) ? $_POST['address'] : '' ?>" required>
						
							<label for="city">City:</label>
							<input class="form-horizontal" id="city" placeholder="City" type="text" name="city" value="<?= (!$isValid && !empty($_POST['city'])) ? $_POST['city'] : '' ?>" required>
						
							<label for="state">State:</label>
							<input class="form-horizontal" id="state" placeholder="State" type="text" name="state" value="<?= (!$isValid && !empty($_POST['state'])) ? $_POST['state'] : '' ?>"required>
						
							<label for="zip">Zip:</label>
							<input class="form-horizontal" id="zip" placeholder="Zip Code" type="text" name="zip" value="<?= (!$isValid && !empty($_POST['zip'])) ? $_POST['zip'] : '' ?>"required>
					
						
						<input type='submit' value="Add Contact" class="btn btn-success">

					</form>
				<?	//display button to go to existing address form ?>
					<a href="?contact=<?=$this_guy?>&add_address=true&new=false" class="btn btn-primary">Existing Address</a>
			<?  else : ?>
				<? //display existing address form ?>
					<form method="POST" action="contact-addresses.php?contact=<?=$this_guy?>" class="form-horizontal">
						<!--only show error message if form input is not valid-->
						<h3>Choose Existing Address</h3>
						<select name="address_exists">
							<? foreach ($existingAddresses as  $address) : ?>
									<option value="<?=$address['id']?>"><?=$address['address']?></option>
							<? endforeach; ?>

						</select> 

						<input type='submit' value="Add Contact" class="btn btn-success">
					</form>
				<? //display button to go to new address form ?>
					<a href="?contact=<?=$this_guy?>&add_address=true&new=true" class="btn btn-primary">New Address</a>
			<? endif;
		endif; 
	else : ?>
		<a href="?contact=<?=$this_guy?>&add_address=true&new=false" class="btn btn-success">Add Address</a>
 <? endif; ?>


	 <form id="removeForm" action="contact-addresses.php?contact=<?=$this_guy?>" method="POST">
	    <input id="removeId" type="hidden" name="remove" value="">
	</form>


	<a id="home" href="contact.php" class="btn btn-default">Back to Contacts</a>

</body>
</html>

<script>
	$('.remove-me').click(function(){
		var contact = $(this).data('contact');
		if(confirm('Are you sure you want to delete this contact?')){
			$('#removeId').val(contact);
        	$('#removeForm').submit();
		}
	})

</script>