<?php
session_start();
require_once 'helper.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "start") {
	session_unset();
	$_SESSION['player_id'] = uniqid();
	$_SESSION['availableLetters'] = generateRandomString(15);
	$_SESSION['highScores'] = [];
	redirect("game.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Word Game</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			padding: 20px;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		.start-button-container {
			text-align: center;
		}

		.start-button {
			width: 200px;
			height: 200px;
			border-radius: 50%;
			font-size: 24px;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="start-button-container">
			<h2 class="mt-5 mb-3">Word Game</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<input type="hidden" name="action" value="start">
				<button type="submit" class="btn btn-primary start-button">Start Game</button>
			</form>
		</div>
	</div>
</body>

</html>