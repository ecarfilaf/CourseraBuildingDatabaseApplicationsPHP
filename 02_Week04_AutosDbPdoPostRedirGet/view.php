<?php
	session_start();

	require_once "./partials/pdo.php";
	
	if ( ! isset($_SESSION['name']) ) {
		die('Not logged in');
	}

	$data = false;

	$isDel = isset($_POST['delete']) ? true : false;
	$idDelete = isset($_POST['delete']) ? $_POST['delete'] : -1;

	if ($isDel){
		$sql = "DELETE FROM autos WHERE auto_id = :zip";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(':zip' => $idDelete));
		$_SESSION['success'] = 'Record deleted';
		header("Location: view.php");
		return;
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
			<h1>Tracking Autos for <?php echo htmlentities($_SESSION['name']) ; ?></h1>
		</div>
	</header>
	<main class="container">
		<?php
			if (isset($_SESSION['success'])) {
				echo ("<p style='color: green;' class='alert alert-success'>");
				echo (htmlentities($_SESSION['success']));
				echo ("</p>");
				unset($_SESSION['success']);
			}
		?>

		<form method="POST">
		<div class="mt-5">
			<h2>Automobiles</h1><a href ="add.php">Add New</a>
				<div class="row mt-3">
					<div class="col-1">
						<button type="submit" class="btn btn-primary" formaction="add.php" >Add New</button>
					</div>
					<div class="col-1">
						<button type="submit" class="btn btn-danger" formaction="logout.php">Logout</button>
					</div>
				</div>
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
		<div>
		<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
		</div>
	</main>
	<?php
		require("./partials/footer.php");
	?>
</body>
</html>