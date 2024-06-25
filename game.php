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
            $_SESSION['availableLetters'] = generateRandomString(15);
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

// Output flash message if set
$flashMessage = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
unset($_SESSION['flash_message']); // Clear flash message after displaying
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
        <div class="text-center mt-5 mb-3">
            <h2>Word Game - Player <?php echo $playerId; ?></h2>
        </div>
        <?php if (!empty($flashMessage)) : ?>
            <div class="alert alert-info"><?php echo $flashMessage; ?></div>
        <?php endif; ?>
        <?php if (!$gameEnded) : ?>
            <div class="text-center mt-5 mb-4">
                <h3><?php echo $availableLetters; ?></h3>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <form action="process.php" method="post">
                        <input type="hidden" name="action" value="submit_word">
                        <div class="form-group">
                            <label for="wordInput">Enter a word:</label>
                            <input type="text" id="wordInput" name="wordInput" class="form-control" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </form>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-2">
                    <form action="process.php" method="post">
                        <input type="hidden" name="action" value="end_game">
                        <button type="submit" class="btn btn-danger btn-block">End Game</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($gameEnded && !empty($_SESSION['highScores'])) : ?>
            <div class="text-center mt-5">
                <h3>Final High Scores</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
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
            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="action" value="restart_game">
                        <button type="submit" class="btn btn-primary btn-block">Restart Game</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($_SESSION['highScores'])) : ?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="action" value="exit">
                        <button type="submit" class="btn btn-danger btn-block">Exit Game</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>