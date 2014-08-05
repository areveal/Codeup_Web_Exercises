<html>
<head>



	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<script src="../js/jquery/jquery.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

	<!--style sheet-->
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

		#parks	{
			position: absolute;
			left: 1075px;
			top:200px;
			border: 1px solid black;
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
		.table {
			width:75%;
		}
		#home {
			position: absolute;
			top: 25px;
			right: 150px;
		}
	</style>


	<title>National Parks Table</title>

</head>
<body>

	<h1 id="head">National Parks</h1>
	
	<?

	// Get new instance of PDO object
	$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', "$ENV[DB_USER]", "$ENV[DB_PASS]");

	// Tell PDO to throw exceptions on error
	$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//these are for form validation
	$isValid = false;
	$not_filled_out = false;

	//check if park was added
	if(!empty($_POST) && !isset($_GET['search'])){

		if(!empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['date']) && !empty($_POST['area']) && !empty($_POST['description'])) {
			// Get new instance of PDO object
			$isValid=true;

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

	//check if search was made
	if(!isset($_GET['search'])) {
		$stmt = $dbc->query('SELECT * FROM parks');
	} else {
		$keyword = $_GET['search'];
		$stmt = $dbc->query("SELECT * FROM parks 
	    						WHERE name LIKE '%$keyword%' OR 
	    						location LIKE '%$keyword%' OR 
	    						date_established LIKE '%$keyword%' OR 
	    						area_in_acres LIKE '%$keyword%' OR 
	    						description LIKE '%$keyword%'");
	}

	//pagination variables
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
	    if(isset($_GET['search'])) {
	    	$keyword = $_GET['search'];
	    	$stmt = $dbc->prepare("SELECT * FROM parks 
	    						WHERE name LIKE '%$keyword%' OR 
	    						location LIKE '%$keyword%' OR 
	    						date_established LIKE '%$keyword%' OR 
	    						area_in_acres LIKE '%$keyword%' OR 
	    						description LIKE '%$keyword%'
	    						LIMIT 4 OFFSET :offset");
	    } else {
	    	$stmt = $dbc->prepare("SELECT * FROM parks LIMIT 4 OFFSET :offset");
	    }
	    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	    $stmt->execute();
	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

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

	<? $searchstring = (isset($keyword)) ? "&search=$keyword" : ""  ?>

	<? if($page > 1) : ?>
	<a href="?page=<?=($page-1).$searchstring?>"><span class="glyphicon glyphicon-arrow-left"></span></a>
	<? endif;?>
	<? for ($i=1 ; $i <= $page_num; $i++) : ?>
		
		<a href="?page=<?= $i.$searchstring?>"><span class="glyphicon"><?= $i ?></span></a>
		
	<? endfor; ?>

	<?if($page < $page_num) :?>
		<a href="?page=<?=($page+1).$searchstring?>"><span class="glyphicon glyphicon-arrow-right"></span></a>
	<?endif;?>





	<div id="parks"></div>

	<? if($not_filled_out) : ?>
		<h1 id="error">You must fill out all fields to add a park.</h1>
	<? endif; ?>

	<h2 id="form_head">Add New Park</h2>
	<form action="national_parks.php?page=<?=$page?>" method="POST" role="form">
		<label for="name">Name:</label><br>
		<input class="form-control" type="text" id="name" name="name" placeholder="Park Name" value="<?= (!empty($_POST) && !empty($_POST['name']) && $isValid == false) ? $_POST['name'] : '' ?>"><br>

		<label for="location">Location:</label><br>
		<input class="form-control" type="state" id="location" name="location" placeholder="Park State" value="<?= (!empty($_POST) && !empty($_POST['location']) && $isValid == false) ? $_POST['location'] : '' ?>"><br>

		<label for="name">Date Established:</label><br>
		<input class="form-control" type="date" id="date" name="date" value="<?= (!empty($_POST) && !empty($_POST['date']) && $isValid == false) ? $_POST['date'] : '' ?>"><br>

		<label for="name">Area in Acres:</label><br>
		<input class="form-control" type="number" id="area" name="area" placeholder="Area" value="<?= (!empty($_POST) && !empty($_POST['area']) && $isValid == false) ? $_POST['area'] : '' ?>"><br>

		<label for="description">Description:</label><br>
		<textarea rows="5" id="description" class="form-control" name="description" placeholder="Give a brief description of the park"><?= (!empty($_POST) && !empty($_POST['description']) && $isValid == false) ? $_POST['description'] : '' ?></textarea><br>


		<input type="submit">
	</form>

	<form id="search" action="national_parks.php" method="GET">
		<input type="search" placeholder="Keyword" name="search">
		<button>Search</button>
	</form>

	<a href="national_parks.php" id="home"><button>Home</button></a>



</body>
</html>


<script>
	<?foreach (getParks($dbc, $offset) as $park) : ?>
	$("#<?=$park['area_in_acres']?>").mouseenter(function(){
		$('body').css('background-image', 'url("../img/<?=$park["area_in_acres"]?>fade.jpg")');
	});
	<?endforeach;?>

	<?foreach (getParks($dbc, $offset) as $park) : ?>
	$("#<?=$park['area_in_acres']?>").mouseleave(function(){

	});
	<?endforeach;?>

	<?foreach (getParks($dbc, $offset) as $park) : ?>
	$("#<?=$park['area_in_acres']?>").click(function(){
		window.open('http://en.wikipedia.org/wiki/<?=$park["name"]?>_National_Park');
	});
	<?endforeach;?>
	

</script>