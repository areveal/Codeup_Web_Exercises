<?
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=address_book', 'cole', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_GET['page'])) {
	$page = 1;
} else {
	$page = $_GET['page'];
}

$offset = ($page * 5) - 5;
//lets get total pages for pagination
function getPageNum($dbc) {
	$stmt = $dbc->query("SELECT name, id, phone
						FROM people");
	return $stmt->fetchAll();
}
$total_num = count(getPageNum($dbc));
$last_page = ceil($total_num/5);

function getContacts($dbc, $offset) {
	$stmt = $dbc->prepare("SELECT name, id, phone
						FROM people
						ORDER BY name
						LIMIT 5 OFFSET :offset
						");
	
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

//check to see if all the required fields were filled out
try{

	if(!empty($_POST['name']) ){
		//validate inputs
        if (strlen($_POST['name']) > 125) {
            throw new InvalidInputException("We're sorry. Your {$key} must be shorter than 125 characters.");
        }
		//create new address to add
		$query = "INSERT INTO people (name,phone) 
					VALUES (:name, :phone)";

		$stmt = $dbc->prepare($query);

		
	    $stmt->bindValue(':name', ucfirst($_POST['name']), PDO::PARAM_STR);
	    $stmt->bindValue(':phone', $_POST['phone'], PDO::PARAM_STR);

	    $stmt->execute();

	
	}

}catch(Exception $e){
	$msg = $e->getMessage();
}

//remove items if we get an index to remove

if(isset($_POST['remove'])) {
	//remove mapping id first
	$stmt = $dbc->prepare("DELETE FROM people_add WHERE people_id = :id");
	$stmt->bindValue(':id', $_POST['remove'], PDO::PARAM_STR);
	$stmt->execute();
	//remove item at 'id'
	$stmt = $dbc->prepare("DELETE FROM people WHERE id = :id");
	$stmt->bindValue(':id', $_POST['remove'], PDO::PARAM_STR);
	$stmt->execute();
	//reload page
	header("Location: contact.php");
	exit(0);	
}


$address_book = getContacts($dbc, $offset);


?>

<!DOCTYPE html>
<html>
<head>
	<title>Contacts DB</title>
	
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

	<style>
		.glyphicon {
			font-size: 30px;
			margin-left: 30px;
		}
		.btn-danger {
			margin-left: 20px;
			position: relative;
			left: -80px;
		}
		.btn-info {
			position: relative;
			left: -80px;
		}
	</style>


</head>
<body>

	<h1>Contacts</h1>

	<!--here is our address book loop -->
	<table class="table table-striped">
		<tr><th>Name</th><th>Phone #</th><th>Actions</th></tr>
		<? if(!empty($address_book)) : ?>
			<? foreach($address_book as $key => $contact) : ?>
				<tr>
					<td><?= $contact['name'] ?></a></td>
					<td><?=$contact['phone']?></td>
					<td><a href="contact-addresses.php?contact=<?=$contact['id']?>" class="btn btn-info">View Info</a><button data-contact="<?=$contact['id']?>" class="btn btn-danger remove-me">Remove Contact</button></td>
				</tr>
			<? endforeach; ?>
		<? endif; ?>
	</table>

	<!--pagination-->
	<? if($page > 1) : ?>
		<a href="?page=<?=$page-1?>"><span class="glyphicon glyphicon-arrow-left"></span></a>
	<? endif; ?>
	<? if($page < $last_page) : ?>
		<a href="?page=<?=$page+1?>"><span class="glyphicon glyphicon-arrow-right"></span></a>
	<? endif; ?>


	<!--'sticky' form-->
	<form method="POST" action="contact.php" class="form-horizontal">
		<h2>Add Contacts</h2>

		<!--only show error message if form input is not valid-->
		<? 
		 	if(isset($msg)) { 
				echo "<h2 style='color:red'>$msg</h2>"; 
		    } 
		?>
		<input class="form-horizontal" id="name" placeholder="Contact Name" type="text" name="name">
		<input class="form-horizontal" id="phone" placeholder="Phone #" type="text" name="phone">
		<input type="submit" class="btn btn-success">

	</form>

	<form id="removeForm" action="contact.php" method="POST">
	    <input id="removeId" type="hidden" name="remove" value="">
	</form>

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