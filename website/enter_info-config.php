<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('');


//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://URL.com/index.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

// Setting for email restriction
$email_restriction = ''; // y/yes or n/no

// If you have restricted email active this is the ending domain.
$email_domain = 'gmail.com'; // Defualt "gmail.com"

//start session on web page
session_start();

?>