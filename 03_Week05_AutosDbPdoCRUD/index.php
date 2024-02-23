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
			<h1>Welcome to Autos Database v03</h1>
		</div>
	</header>
	<main class="container">
		<p><a href="login.php">Please log in</a></p>
		<p>	Attempt to <a href="add.php">Add data</a> without logging.</p>
		<p>	Attempt to <a href="delete.php">Delete data</a> without logging.</p>
		<a href="delete.php?autos_id=0">Delete</a>
	</main>
	<?php
		require("./partials/footer.php");
	?>
</body>
</html>