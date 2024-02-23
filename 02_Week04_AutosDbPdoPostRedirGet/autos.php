<?php
	require_once "./partials/pdo.php";
	// Demand a GET parameter
	if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
		die('Name parameter missing');
	}
	$inMake = isset($_POST['make']) ? $_POST['make'] : '';
	$inYear = isset($_POST['year']) ? $_POST['year'] : 0;
	$inMileage = isset($_POST['mileage'])?$_POST['mileage']: 0;
	$message = false;
	$message2 = false;
	$data = false;

	$isDel = isset($_POST['delete']) ? true : false;
	$idDelete = isset($_POST['delete']) ? $_POST['delete'] : -1;
	print_r ($idDelete);

	if (!$isDel){
		if (isset($_POST['make'])){
			if (strlen(rtrim(ltrim($inMake))) == 0) $message = 'Make is required';
			if ((!is_numeric($inYear)) && ($message == false)) $message = 'Mileage and year must be numeric';
			if ((!is_numeric($inMileage)) && ($message == false)) $message = 'Mileage and year must be numeric';

			if ($message == false){
				$sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(array(
					':make' => $inMake,
					':year' => $inYear,
					':mileage' => $inMileage));
				$message2 = 'Record inserted';
			}
		}
	} else {
		$sql = "DELETE FROM autos WHERE auto_id = :zip";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(':zip' => $idDelete));
		$message2 = 'Record deleted';
	}

	$stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($rows) > 0) $data = true;
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		require("./partials/header.php");
	?>
</head>
<body>
	<header>
		<div class="container">
			<h1>Tracking Autos for <?php echo htmlentities($_REQUEST['name']) ; ?></h1>
		</div>
	</header>
	<main class="container">
		<?php
			if ($message !== false) {
				echo ("<p class='alert alert-danger'>");
				echo ($message);
				echo ("</p>");
			}
			if ($message2 !== false) {
				echo ("<p class='alert alert-success'>");
				echo ($message2);
				echo ("</p>");
			}
		?>
		<form method="POST">
			<div class="form-group row mt-3">
				<label for="make" class="col-sm-1 col-form-label">Make : </label>
				<div class="col-sm-3">
					<input type="text"  class="form-control" id="make" name="make" >
				</div>
			</div>
			<div class="form-group row mt-2">
				<label for="year" class="col-sm-1 col-form-label">Year :</label>
				<div class="col-sm-1">
					<input type="text" class="form-control" id="year" name="year">
				</div>
			</div>
			<div class="form-group row mt-2">
				<label for="mileage" class="col-sm-1 col-form-label">Mileage :</label>
				<div class="col-sm-1">
					<input type="text" class="form-control" id="mileage" name="mileage">
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-1">
					<button type="submit" class="btn btn-primary">Add New</button><a href="add.php">Add New</a>
				</div>
				<div class="col-1">
					<button type="submit" class="btn btn-danger" formaction="index.php" >logout</button>
				</div>
			</div>
		<div class="mt-5">
			<h2>Automobiles</h1>
			<?php
			if ($data == true){
			?>
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
					<th>#</th>
					<th>Make</th>
					<th>Year</th>
					<th>Mileage</th>
					<th>Action</th>
					</tr>
					</thead>
					<tbody>
				<?php
				foreach ( $rows as $row ) {
					echo "<tr><td>".$row['auto_id']."</td><td>".htmlentities($row['make'])."</td><td>".$row['year']."</td><td>".$row['mileage']."</td><td><button name='delete' value='".$row['auto_id']."' type='submit' class='btn btn-outline-danger' >
					<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
					<path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5'>
					</path></svg> Delete</button></td></tr>";
				}
				?>
					</tbody>
				</table>
			</div>
			<?php	
			}
			?>
		</div>
		</form>
		<div class="row mt-3">
				<div>
					<button type="submit" class="btn btn-primary" formaction="add.php" >Add New Entry</button>
					<button type="submit" class="btn btn-danger" formaction="logout.php">Logout</button>
					<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
				</div>
			</div>
	</main>
	<footer class="panel-footer">
		<p>&copy; ECAN 2024</p>
	</footer>
</body>
</html>