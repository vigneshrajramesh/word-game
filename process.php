<?php
session_start();
require_once 'helper.php';

// Function to validate if input word can be formed from available letters
function isValidWord($word, $availableLetters)
{
	$wordCount = array_count_values(str_split($word));
	$availableCount = array_count_values(str_split($availableLetters));

	foreach ($wordCount as $char => $count) {
		if (!isset($availableCount[$char]) || $availableCount[$char] < $count) {
			return false;
		}
	}

	// For simplicity, assume all submitted words are valid
	return true;
}

// Function to calculate score based on word length
function scoreWord($word)
{
	return strlen($word);
}

// Function to update available letters
function updateAvailableLetters($word, $availableLetters)
{
	foreach (str_split($word) as $char) {
		$pos = strpos($availableLetters, $char);
		if ($pos !== false) {
			$availableLetters = substr_replace($availableLetters, '', $pos, 1);
		}
	}
	return $availableLetters;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
	switch ($_POST["action"]) {
		case "submit_word":
			$submittedWord = trim($_POST["wordInput"]);

			if (!isValidWord($submittedWord, $_SESSION['availableLetters'])) {
				die("Error: Invalid word or cannot be formed with available letters.");
			}

			$score = scoreWord($submittedWord);
			$_SESSION['highScores'][$submittedWord] = $score;
			$_SESSION['availableLetters'] = updateAvailableLetters($submittedWord, $_SESSION['availableLetters']);

			if (empty($_SESSION['availableLetters'])) {
				redirect("game.php");
			}
			redirect("game.php");
			break;

		case "end_game":
			redirect("game.php");
			break;
	}
}
