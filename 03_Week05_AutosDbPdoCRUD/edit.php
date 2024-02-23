<?php
	session_start();

	require_once "./partials/pdo.php";
	
	if ( ! isset($_SESSION['name']) ) {
		die('Not logged in');
	}

	$isPost = false;
	$message = false;

	if (!$isPost && isset($_POST['make'])) $isPost = true;
	if (!$isPost && isset($_POST['model'])) $isPost = true;
	if (!$isPost && isset($_POST['year'])) $isPost = true;
	if (!$isPost && isset($_POST['mileage'])) $isPost = true;

	if ($isPost){
		$make = isset($_POST['make']) ? $_POST['make'] : '';
		$model = isset($_POST['model']) ? $_POST['model'] : '';
		$year = isset($_POST['year']) ? $_POST['year'] : 0;
		$mileage = isset($_POST['mileage'])?$_POST['mileage']: 0;
		$autoId = isset($_SESSION['auto_id'])?$_SESSION['auto_id']: 0;

		if (strlen(rtrim(ltrim($make))) == 0) $message = 'Make is required';
		if ((!is_numeric($year)) && ($message == false)) $message = 'Mileage and year must be numeric';
		if ((!is_numeric($mileage)) && ($message == false)) $message = 'Mileage and year must be numeric';
		if (strlen(rtrim(ltrim($model))) == 0) $message = 'All fields are required';

		if ($message == false){
			$sql = "Update autos Set make = :make, model = :model , year = :year , mileage = :mileage Where auto_id = :auto_id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':make' => $make,
				':model' => $model,
				':year' => $year,
				':mileage' => $mileage,
				':auto_id' => $autoId));
			$_SESSION['success'] = "Record updated";
			unset($_SESSION['erroredit']);
			unset($_SESSION['make']);
			unset($_SESSION['model']);
			unset($_SESSION['year']);
			unset($_SESSION['mileage']);
			header("Location: view.php");
			return;
		} else {
			$_SESSION['erroredit'] = $message;
			$_SESSION['make'] = $make;
			$_SESSION['model'] = $model;
			$_SESSION['year'] = $year;
			$_SESSION['mileage'] = $mileage;
			header("Location: edit.php");
			return;
		}
	} else {
		$data = false;
		if (isset($_POST['edit'])){
			$autoId = $_POST['edit'];
			$_SESSION['auto_id'] = $autoId;

			$sql = "SELECT make, model, year, mileage, auto_id FROM autos Where auto_id = " . $autoId;
			$stmt = $pdo->query($sql);
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($rows) > 0) {
				$data = true;
				$row = $rows[0];
				$_SESSION['make'] = $row['make'];
				$_SESSION['model'] = $row['model'];
				$_SESSION['year'] = $row['year'];
				$_SESSION['mileage'] = $row['mileage'];
			}
		}
		$make = $_SESSION['make'];
		$model = $_SESSION['model'];
		$year = $_SESSION['year'];
		$mileage = $_SESSION['mileage'];
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
			if (isset($_SESSION['erroredit'])) {
				echo ("<p class='alert alert-danger'>");
				echo (htmlentities($_SESSION['erroredit']));
				echo ("</p>");
				unset($_SESSION['erroredit']);
			}
		?>
		<form method="POST">
			<div class="form-group row mt-3">
				<label for="make" class="col-sm-1 col-form-label">Make : </label>
				<div class="col-sm-3">
					<input type="text"  class="form-control" id="make" name="make" value = '<?php echo htmlentities($make); ?>'>
				</div>
			</div>
			<div class="form-group row mt-3">
				<label for="model" class="col-sm-1 col-form-label">Model : </label>
				<div class="col-sm-3">
					<input type="text"  class="form-control" id="model" name="model" value = '<?php echo htmlentities($model); ?>'>
				</div>
			</div>
			<div class="form-group row mt-2">
				<label for="year" class="col-sm-1 col-form-label">Year :</label>
				<div class="col-sm-1">
					<input type="text" class="form-control" id="year" name="year" value = '<?php echo $year; ?>'>
				</div>
			</div>
			<div class="form-group row mt-2">
				<label for="mileage" class="col-sm-1 col-form-label">Mileage :</label>
				<div class="col-sm-1">
					<input type="text" class="form-control" id="mileage" name="mileage" value = '<?php echo $mileage; ?>'>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-1">
					<button type="submit" class="btn btn-primary" value="Save">Save</button>
				</div>
				<div class="col-1">
					<button type="submit" class="btn btn-danger" formaction="view.php" >Cancel</button>
				</div>
			</div>
		</form>
	</main>
	<?php
		require("./partials/footer.php");
	?>
</body>
</html>