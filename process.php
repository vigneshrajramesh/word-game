<?php
error_reporting(E_ERROR | E_PARSE);
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

// Function to check if a word is valid using dictionary API
function isValidEnglishWord($word)
{
	$api_url = "https://api.dictionaryapi.dev/api/v2/entries/en/" . urlencode($word);
	// Make GET request to API
	$response = file_get_contents($api_url);

	if ($response === false) {
		// Handle API request error
		return false;
	}

	// Decode JSON response
	$data = json_decode($response, true);

	// Check if API returned valid data
	if (is_array($data) && isset($data[0]['meanings'])) {
		// Word is valid if API returned meanings
		return true;
	} else {
		// Word is not valid or API did not return meanings
		return false;
	}
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
				$_SESSION['flash_message'] = "Error: Given word cannot be formed with available letters.";
				redirect("game.php");
			}
			if (!isValidEnglishWord($submittedWord)) {
				$_SESSION['flash_message'] = "Error: Invalid word.";
				redirect("game.php");
			} else {
				$score = scoreWord($submittedWord);
				$_SESSION['highScores'][$submittedWord] = $score;
				$_SESSION['availableLetters'] = updateAvailableLetters($submittedWord, $_SESSION['availableLetters']);

				if (empty($_SESSION['availableLetters'])) {
					redirect("game.php");
				}
				redirect("game.php");
			}
			break;

		case "end_game":
			$_SESSION['availableLetters'] = '';
			$_SESSION['flash_message'] = "Game ended. Final scores are shown below.";
			if (empty($_SESSION['highScores'])) {
				redirect("index.php");
			}
			redirect("game.php");
			break;
	}
}
