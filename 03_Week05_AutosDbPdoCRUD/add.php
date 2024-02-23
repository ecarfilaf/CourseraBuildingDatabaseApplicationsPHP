<?php
	session_start();

	require_once "./partials/pdo.php";
	
	if ( ! isset($_SESSION['name']) ) {
		die('ACCESS DENIED');
	}

	$isPost = false;
	$message = false;

	if (!$isPost && isset($_POST['make'])) $isPost = true;
	if (!$isPost && isset($_POST['model'])) $isPost = true;
	if (!$isPost && isset($_POST['year'])) $isPost = true;
	if (!$isPost && isset($_POST['mileage'])) $isPost = true;

	if ($isPost){
		$inMake = isset($_POST['make']) ? $_POST['make'] : '';
		$inModel = isset($_POST['model']) ? $_POST['model'] : '';
		$inYear = isset($_POST['year']) ? $_POST['year'] : 0;
		$inMileage = isset($_POST['mileage'])?$_POST['mileage']: 0;

		if (strlen(rtrim(ltrim($inMake))) == 0) $message = 'Make is required';
		if ((!is_numeric($inYear)) && ($message == false)) $message = 'Mileage and year must be numeric';
		if ((!is_numeric($inMileage)) && ($message == false)) $message = 'Mileage and year must be numeric';
		if (strlen(rtrim(ltrim($inModel))) == 0) $message = 'All fields are required';

		if ($message == false){
			$sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':make' => $inMake,
				':model' => $inModel,
				':year' => $inYear,
				':mileage' => $inMileage));
			$_SESSION['success'] = "added";
			header("Location: view.php");
			return;
		} else {
			$_SESSION['erroradd'] = $message;
			header("Location: add.php");
			return;
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
			if (isset($_SESSION['erroradd'])) {
				echo ("<p class='alert alert-danger'>");
				echo (htmlentities($_SESSION['erroradd']));
				echo ("</p>");
				unset($_SESSION['erroradd']);
			}
		?>
		<form method="POST">
			<div class="form-group row mt-3">
				<label for="make" class="col-sm-1 col-form-label">Make : </label>
				<div class="col-sm-3">
					<input type="text"  class="form-control" id="make" name="make" >
				</div>
			</div>
			<div class="form-group row mt-3">
				<label for="model" class="col-sm-1 col-form-label">Model : </label>
				<div class="col-sm-3">
					<input type="text"  class="form-control" id="model" name="model" >
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
					<button type="submit" class="btn btn-primary" value="Add">Add</button>
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