<?php
include('config.php');

// Checks i f person got sent to the script file thrue the open button
if (isset($_POST['open-submit'])) {

    if (empty($_SESSION['user_first_name']) || empty($_SESSION['user_last_name']) || empty($_SESSION['user_email_address'])) {
        //Destroy entire session data.
        session_destroy();
        header('Location: ../index.php?err=not-loged-in-properly');
        exit();
    }

    //Reset OAuth access token
    $google_client->revokeToken();

    //Destroy entire session data.
    session_destroy();

    //redirect page to index.php
    header('location: ../index.php');
}
else  {
    header('Location: ../index.php?err=Dont-be-a-dick');
    exit();
}

