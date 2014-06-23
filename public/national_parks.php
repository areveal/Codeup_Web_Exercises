<html>
<head>


	<style>
		body {
			background-image: url('../img/park.jpg');
			background-size: cover;
			color:#fff;
		}
		.glyphicon,.page {
			font-size: 30px;
			left:100px;
			color:#fff;
		}
		.page {
			position: relative;
		}
		#head,table {
			color: #fff;
		}
	</style>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

	<title>National Parks Table</title>
</head>
<body>

<h1 id="head">National Parks</h1>
<?
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'cole', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!empty($_GET)) {
	$offset = intval($_GET['start']);
} else {
	$offset = 0;
}


//this will get us our data
function getParks($dbc, $offset) {
    // Bring the $dbc variable into scope somehow
    return $dbc->query("SELECT * FROM parks LIMIT 4 OFFSET $offset")->fetchAll(PDO::FETCH_ASSOC);
}
?>


<table class="table table-hover">
	<tr>
		<th>Name</th>
		<th>Location</th>
		<th>Date Established</th>
		<th>Area in Acres</th>
	</tr>
	<? foreach(getParks($dbc, $offset) as $park) : ?>	
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
<? if($offset > 0) : ?>
<a href="?start=<?=$offset-4?>"><span class="glyphicon glyphicon-arrow-left"></span></a>
<? endif;?>
<a class ="page" href="?start=0">1</a>
<a class ="page" href="?start=4">2</a>
<a class ="page" href="?start=8">3</a>
<?if($offset < 8) :?>
	<a href="?start=<?=$offset+4?>"><span class="glyphicon glyphicon-arrow-right"></span></a>
<?endif;?>


</body>
</html>
