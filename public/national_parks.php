<html>
<head>


	<?


		$isValid = false;
		$not_filled_out = false;


		if(!empty($_POST) && !isset($_POST['search'])){

			if(!empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['date']) && !empty($_POST['area']) && !empty($_POST['description'])) {
				// Get new instance of PDO object
				$isValid=true;
				$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'cole', 'password');

				// Tell PDO to throw exceptions on error
				$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$query = "INSERT INTO parks (name, location, date_established, area_in_acres, description) 
							VALUES (:name, :location, :date_established, :area_in_acres, :description)";

				$stmt = $dbc->prepare($query);

				
			    $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
			    $stmt->bindValue(':location', $_POST['location'], PDO::PARAM_STR);
			    $stmt->bindValue(':date_established', $_POST['date'], PDO::PARAM_STR);
			    $stmt->bindValue(':area_in_acres', $_POST['area'], PDO::PARAM_INT);
			    $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);

			    $stmt->execute();

				
			} else {
				$not_filled_out = true;
			}
		}

	?>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<script src="../js/jquery/jquery.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


	<style>
		body {
			background-image: url(../img/canyon.jpg);
			background-size: cover;
		}
		.glyphicon,.page {
			font-size: 30px;
			left:100px;
			color:#000;
		}
		.page {
			position: relative;
		}
		#head,table, #form_head,label {
			color: #000;
		}

		div	{
			position: absolute;
			left: 500px;
			top:450px;
		}

		#picture {
			height: 200px;
			width: 350px;
		}
		#search {
			position: absolute;
			left: 975px;
			top: 25px;
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

	if(!isset($_POST['search'])) {
		$stmt = $dbc->query('SELECT * FROM parks');
	} else {
		$keyword = $_POST['search'];
		$stmt = $dbc->prepare("SELECT * FROM parks 
	    						WHERE name LIKE '%$keyword%' OR location LIKE '%$keyword%' OR date_established LIKE '%$keyword%' OR area_in_acres LIKE '%$keyword%' OR description LIKE '%$keyword%'
	    						LIMIT 4 OFFSET :offset");
	}

	$page_num = ceil(($stmt->rowCount())/4);


	if(isset($_GET['page']) && ($_GET['page']) >1 && ($_GET['page']) <= $page_num) {
		$page = $_GET['page'];
		$offset = (intval($page)-1)*4;
	} else {
		$page = 1;
		$offset = 0;
	}


	//this will get us our data
	function getParks($dbc, $offset) {
	    // Bring the $dbc variable into scope somehow
	    if(isset($_POST['search'])) {
	    	$keyword = $_POST['search'];
	    	$stmt = $dbc->prepare("SELECT * FROM parks 
	    						WHERE name LIKE '%$keyword%' OR location LIKE '%$keyword%' OR date_established LIKE '%$keyword%' OR area_in_acres LIKE '%$keyword%' OR description LIKE '%$keyword%'
	    						LIMIT 4 OFFSET :offset");
	    } else {
	    	$stmt = $dbc->prepare("SELECT * FROM parks LIMIT 4 OFFSET :offset");
	    }
	    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	    $stmt->execute();

	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// var_dump(getParks($dbc,$offset));
	?>


	<table class="table table-hover">
		<tr>
			<th>Name</th>
			<th>Location</th>
			<th>Date Established</th>
			<th>Area in Acres</th>
			<th>Description</th>
		</tr>
		<? if(count(getParks($dbc,$offset)) > 0) { ?>
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
					<td>
						<?= $park['description']?>
					</td>
				</tr>
			<? endforeach; ?>
			</table>
		<? } else { ?>
			</table>
			<h2><?= "The search returned no results"?></h2>
		<? } ?>	



	<? if($page > 1) : ?>
	<a href="?page=<?=$page-1?>"><span class="glyphicon glyphicon-arrow-left"></span></a>
	<? endif;?>
	<?if($page < $page_num) :?>
		<a href="?page=<?=$page+1?>"><span class="glyphicon glyphicon-arrow-right"></span></a>
	<?endif;?>





	<div id="parks"></div>

	<? if($not_filled_out) : ?>
		<h1 id="error">You must fill out all fields to add a park.</h1>
	<? endif; ?>

	<h2 id="form_head">Add New Park</h2>
	<form action="national_parks.php?page=<?=$page?>" method="POST">
		<label for="name">Name:</label><br>
		<input type="text" id="name" name="name" placeholder="Park Name" value="<?= (!empty($_POST) && !empty($_POST['name']) && $isValid == false) ? $_POST['name'] : '' ?>"><br>

		<label for="location">Location:</label><br>
		<input type="text" id="location" name="location" placeholder="Park State" value="<?= (!empty($_POST) && !empty($_POST['location']) && $isValid == false) ? $_POST['location'] : '' ?>"><br>

		<label for="name">Date Established:</label><br>
		<input type="text" id="date" name="date" placeholder="YYYY-MM-DD" value="<?= (!empty($_POST) && !empty($_POST['date']) && $isValid == false) ? $_POST['date'] : '' ?>"><br>

		<label for="name">Area in Acres:</label><br>
		<input type="text" id="area" name="area" placeholder="Area" value="<?= (!empty($_POST) && !empty($_POST['area']) && $isValid == false) ? $_POST['area'] : '' ?>"><br>

		<label for="description">Description:</label><br>
		<textarea rows="5" cols="50" id="description" name="description" placeholder="Give a brief description of the park"><?= (!empty($_POST) && !empty($_POST['description']) && $isValid == false) ? $_POST['description'] : '' ?></textarea><br>


		<input type="submit">
	</form>

	<form id="search" action="national_parks.php" method="POST">
		<input type="text" placeholder="Keyword" name="search">
		<button>Search</button>
	</form>



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

	<?foreach (getParks($dbc, $offset) as $park) : ?>
	$("#<?=$park['area_in_acres']?>").dblclick(function(){
		window.open('http://en.wikipedia.org/wiki/<?=$park["name"]?>_National_Park');
	});
	<?endforeach;?>
	
	<?foreach (getParks($dbc, $offset) as $park) : ?>
	$("#<?=$park['area_in_acres']?>").click(function(){
		$('#picture').css('position','absolute');
		$('#picture').css('height','700px');
		$('#picture').css('width','1000px');
		$('#picture').css('top','-450px');
		$('#picture').css('left','-300px');
		$('#picture').hide(250).fadeToggle(2000);
	});
	<?endforeach;?>

</script>