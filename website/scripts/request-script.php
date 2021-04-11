<?php
//Include configuration file.
include('../config.php');

// Require database file for database connecton.
require '../database/db_connection.php';

// Checks if person got sent to the script file through the open button in the index file.
if (isset($_POST['request-submit']))
{
    if (empty($_SESSION['given_name']) || empty($_SESSION['family_name']) || empty($_SESSION['email']))
    {
        //Sends back user if they aren't properly logged in and logs them out.
        require "scripts/logout-script.php";
        header('Location: ../index.php?err=not-logged-in-properly');
        exit();
    }
    else
    {
        // Defining sql query and initalizing a connection to the database.
        $sql = "INSERT INTO RDL_log (given_name, family_name, email) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        // Checking if their is a problem with the sql query.
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            // Sends back user if their is a problem with sql querys sent to database.
            header('Location: ../index.php?err=sqlerr1');
            exit();
        }
        // Inserts email, given_name and family_name.
        else
        {
            // Inputs email, given_name and family_name as an argument into the sql query.
            mysqli_stmt_bind_param($stmt, 'sss', strtolower($_SESSION['given_name']), strtolower($_SESSION['family_name']), strtolower($_SESSION['email']));
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            // Sends back success message.
            header('Location: ../index.php?sus=request-sent');
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// Sends back users who didn't use the button to access the script.
else
{
    header('Location: ../index.php?err=Dont-even-try');
    exit();
}