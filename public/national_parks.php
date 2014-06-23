<html>
<head>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<script src="../js/jquery/jquery.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


	<style>
		body {
			background-color: #A2B2AB;
		}
		.glyphicon,.page {
			font-size: 30px;
			left:100px;
			color:#17FF9C;
		}
		.page {
			position: relative;
		}
		#head,table {
			color: #B21B00;
		}

		div	{
			position: absolute;
			left: 380px;
			top:270px;
		}

		#picture {
			height: 400px;
			width: 600px;
		}
	</style>


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
	$page = $_GET['page'];
	$offset = (intval($page)-1)*4;
} else {
	$page = 1;
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
		<tr id="<?= $park['area_in_acres']?>">
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



<? if($page > 1) : ?>
<a href="?page=<?=$page-1?>"><span class="glyphicon glyphicon-arrow-left"></span></a>
<? endif;?>

<a class ="page" href="?page=1">1</a>
<a class ="page" href="?page=2">2</a>
<a class ="page" href="?page=3">3</a>

<?if($page < 3) :?>
	<a href="?page=<?=$page+1?>"><span class="glyphicon glyphicon-arrow-right"></span></a>
<?endif;?>


<div id="parks"></div>


</body>
</html>


<script>
	<?foreach (getParks($dbc, $offset) as $park) : ?>
	$("#<?=$park['area_in_acres']?>").mouseenter(function(){
		$('#parks').html('<img id="picture" src="../img/<?=$park["area_in_acres"]?>.jpg">');
	});
	<?endforeach;?>

	<?foreach (getParks($dbc, $offset) as $park) : ?>
	$("#<?=$park['area_in_acres']?>").mouseleave(function(){
		$('#picture').remove();
	});
	<?endforeach;?>
</script>