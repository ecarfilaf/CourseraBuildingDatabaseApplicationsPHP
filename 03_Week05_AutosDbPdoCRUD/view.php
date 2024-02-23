<?php
	session_start();

	require_once "./partials/pdo.php";
	
	if ( ! isset($_SESSION['name']) ) {
		die('Not logged in');
	}

	$data = false;

	$stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");
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
			<h1>Welcome to the Automobiles Database</h1>
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
			<?php
			if ($data == true){
			?>
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
					<th>#</th>
					<th>Make</th>
					<th>Model</th>
					<th>Year</th>
					<th>Mileage</th>
					<th colspan=2 >Actions</th>
					</tr>
					</thead>
					<tbody>
			<?php
			foreach ( $rows as $row ) {
				echo "<tr><td>".$row['auto_id']."</td><td>".htmlentities($row['make'])."</td><td>".htmlentities($row['model'])."</td><td>".$row['year']."</td><td>".$row['mileage']."</td><td><button name='edit' value='".$row['auto_id']."' type='submit' formaction='edit.php' class='btn btn-success'>
				<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
				<path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z'></path>
				</svg> Edit</button></td><td><button type='submit' formaction='delete.php?auto_id=".$row['auto_id']."' class='btn btn-danger' >
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
			<div class="row mt-3">
				<div>
					<button type="submit" class="btn btn-primary" formaction="add.php" >Add New Entry</button>
					<button type="submit" class="btn btn-danger" formaction="logout.php">Logout</button>
				</div>
			</div>
		</div>
		</form>
	</main>
	<?php
		require("./partials/footer.php");
	?>
</body>
</html>