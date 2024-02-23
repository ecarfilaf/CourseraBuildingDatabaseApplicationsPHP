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
			<h1>Welcome to Autos Database v02</h1>
		</div>
	</header>
	<main class="container">
		<p><a href="login.php">Please Log In</a></p>
		<p>	Attempt to go to <a href="view.php">view.php</a> without logging in - it should fail with an error message.</p>
		<p>	Attempt to go to <a href="add.php">Add New</a> without logging in - it should fail with an error message.</p>
		<p><a href="https://www.wa4e.com/assn/autosdb/" target="_blank">Specification for this Application</a></p>
	</main>
	<?php
		require("./partials/footer.php");
	?>
</body>
</html>