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
			<h1>Welcome to Autos Database</h1>
		</div>
	</header>
	<main class="container">
		<p><a href="login.php">Please Log In</a></p>
		<p>	Attempt to go to <a href="autos.php">autos.php</a> without logging in - it should fail with an error message.</p>
		<p><a href="https://www.wa4e.com/assn/autosdb/" target="_blank">Specification for this Application</a></p>
		<p>
			<b>Note:</b> Your implementation should retain data across multiple
			logout/login sessions.  This sample implementation clears all its
			data on logout - which you should not do in your implementation.
		</p>
	</main>
	<footer class="panel-footer">
		<p>&copy; ECAN 2024</p>
	</footer>
</body>
</html>