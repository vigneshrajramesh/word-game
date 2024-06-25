<?php
// Function to generate random string of letters
function generateRandomString($length)
{
	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$words = ['APPLE', 'BANANA', 'ORANGE', 'GRAPE', 'PEAR']; // Add more words as needed
	$randomString = '';

	// Ensure at least one word is included
	$selectedWord = $words[rand(0, count($words) - 1)];
	$wordLength = strlen($selectedWord);

	if ($wordLength >= $length) {
		return substr($selectedWord, 0, $length);
	}

	// Add the selected word to the random string
	$randomString .= $selectedWord;
	$remainingLength = $length - $wordLength;

	// Generate remaining random characters
	for ($i = 0; $i < $remainingLength; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}

	// Shuffle the string to ensure the word is mixed with random characters
	$randomString = str_shuffle($randomString);

	return $randomString;
}



// Function to redirect with a given URL
function redirect($url)
{
	header("Location: $url");
	exit();
}
