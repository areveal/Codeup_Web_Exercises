<html>
<head>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

	<title>National Parks Table</title>
</head>
<body>

<h1>National Parks</h1>
<?
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'cole', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//this will get us our data
function getParks($dbc) {
    // Bring the $dbc variable into scope somehow

    return $dbc->query('SELECT * FROM parks LIMIT 4 OFFSET 0')->fetchAll(PDO::FETCH_ASSOC);

}
?>


<table class="table table-hover">
	<tr>
		<th>Name</th>
		<th>Location</th>
		<th>Date Established</th>
		<th>Area in Acres</th>
	</tr>
	<? foreach(getParks($dbc) as $park) : ?>	
	<tr>
		<td>
			<?= $park['name']?>
		</td>
		<td>
			<?= $park['location']?>
		</td>
		<td>
			<?= $park['date_established']?>
		</td>
		<td>
			<?= $park['area_in_acres']?>
		</td>
	</tr>
	<? endforeach; ?>	
</table>

<button>Previous Page</button>
<button>Next Page</button>


</body>
</html>
