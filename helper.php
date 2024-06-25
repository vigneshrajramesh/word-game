<?php
// Function to generate random string of letters
function generateRandomString($length)
{
	$characters = 'abcdefghijklmnopqrstuvwxyz';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

// Function to redirect with a given URL
function redirect($url)
{
	header("Location: $url");
	exit();
}
