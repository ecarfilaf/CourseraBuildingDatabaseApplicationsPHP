<?php
	session_start();

	require_once "./partials/pdo.php";
	
	if ( ! isset($_SESSION['name']) ) {
		die('Not logged in');
	}

	$isPost = false;
	$message = false;
	$isPost = isset($_POST['delete']) ? true : false;

	if ($isPost){
		$autoId = $_GET['auto_id'];
		error_log ($autoId);
		$sql = "DELETE FROM autos WHERE auto_id = :zip";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(':zip' => $autoId));
		$_SESSION['success'] = "Record deleted";
		header("Location: view.php");
		return;
	} else {
		$data = false;
		$autoId = 0;
		if (isset($_GET['auto_id'])){
			$autoId = $_GET['auto_id'];
		}
		
		$sql = "SELECT make, model, year, mileage, auto_id FROM autos Where auto_id = " . $autoId;
		$stmt = $pdo->query($sql);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($rows) > 0) {
			$data = true;
			$row = $rows[0];
			$make = $row['make'];
			$model = $row['model'];
			$year = $row['year'];
			$mileage = $row['mileage'];
		}
	}
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
			if (isset($_SESSION['errordel'])) {
				echo ("<p class='alert alert-danger'>");
				echo (htmlentities($_SESSION['errordel']));
				echo ("</p>");
				unset($_SESSION['errordel']);
			}
		?>
		<form method="POST">
			<div>
				<p>Confirm: Deleting <?php echo htmlentities($make); ?></p>
			</div>
			<div class="row mt-3">
				<div class="col-1">
					<button type="submit" class="btn btn-danger" name='delete' value='delete'>Delete</button>
				</div>
				<div class="col-1">
					<button type="submit" class="btn btn-primary" formaction="view.php" >Cancel</button>
				</div>
			</div>
		</form>
	</main>
	<?php
		require("./partials/footer.php");
	?>
</body>
</html>