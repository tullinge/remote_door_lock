<?php
include('../config.php');
require '../database/db_connection.php';

// Checks if person got sent to the script file thru the open button in the index file.
if (isset($_POST['request-submit']))
{
    if (empty($_SESSION['given_name']) || empty($_SESSION['family_name']) || empty($_SESSION['email']))
    {
        //Sends back user if they artent properly loged in and loges them out.
        $google_client->revokeToken($_SESSION['access_token']);
        session_destroy();
        header('Location: ../index.php?err=not-loged-in-properly');
        exit();
    }
    else
    {
        $sql = "INSERT INTO RDL_log (given_name, family_name, email) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header('Location: ../index.php?err=sqlerr1');
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, 'sss', strtolower($_SESSION['given_name']), strtolower($_SESSION['family_name']), strtolower($_SESSION['email']));
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            header('Location: ../index.php?sus=request-sent');
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else
{
    header('Location: ../index.php?err=Dont-even-try');
    exit();
}