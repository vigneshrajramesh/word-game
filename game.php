<?php
session_start();
require_once 'helper.php';

if (!isset($_SESSION['player_id'])) {
    die("Error: Game session not started.");
}

$gameEnded = empty($_SESSION['availableLetters']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case "restart_game":
            $_SESSION['availableLetters'] = generateRandomString(12);
            $_SESSION['highScores'] = [];
            redirect("game.php");
            break;

        case "exit":
            session_unset();
            session_destroy();
            redirect("index.php");
            break;
    }
}

$playerId = $_SESSION['player_id'];
$availableLetters = $_SESSION['availableLetters'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Game - Player <?php echo $playerId; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-5 mb-3">Word Game - Player <?php echo $playerId; ?></h2>
        <?php if (!$gameEnded) : ?>
            <p>Available letters: <?php echo $availableLetters; ?></p>
            <div class="row">
                <form action="process.php" method="post" class="mb-4">
                    <input type="hidden" name="action" value="submit_word">
                    <div class="form-group">
                        <label for="wordInput">Enter a word:</label>
                        <input type="text" id="wordInput" name="wordInput" class="form-control" autocomplete="off" required>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>
            <div class="row">
                <form action="process.php" method="post">
                    <input type="hidden" name="action" value="end_game">
                    <button type="submit" class="btn btn-sm btn-danger">End Game</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if ($gameEnded && !empty($_SESSION['highScores'])) : ?>
            <h3 class="mt-5">Final High Scores</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Word</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    arsort($_SESSION['highScores']);
                    foreach ($_SESSION['highScores'] as $word => $score) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($word); ?></td>
                            <td><?php echo $score; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="action" value="restart_game">
                <button type="submit" class="btn btn-sm btn-primary mt-3">Restart Game</button>
            </form>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="action" value="exit">
                <button type="submit" class="btn btn-sm btn-danger mt-3">Exit Game</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>