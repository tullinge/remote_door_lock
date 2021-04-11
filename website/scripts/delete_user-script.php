<?php
//Include configuration file.
include('../config.php');

// Require database file for database connecton.
require '../database/db_connection.php';

// Checks if person got sent to the script file thru the open button in the index file.
if (isset($_POST['delete_user-submit']))
{
    //Sends back user if they artent properly logged in and logs them out.
    if (empty($_SESSION['given_name']) || empty($_SESSION['family_name']) || empty($_SESSION['email']))
    {
        require "scripts/logout-script.php";
        header('Location: ../index.php?err=not-loged-in-properly');
        exit();
    }
    else
    {
        // Defining sql query and initalizing a connection to the database.
        $sql = 'SELECT `rank` FROM RDL_users WHERE id=?;';
        $stmt = mysqli_stmt_init($conn);

        // Checking if their is a problem with the sql query.
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            // Sends back user if there is a problem with sql querys sent to database.
            header('Location: ../user_list.php?err=sqlerr1');
            exit();
        }

        // Checks the rank of the user that is trying to remove someone.
        else
        {
            // Inputs the id of the user into the query.
            mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $deleted_user_rank);
            while (mysqli_stmt_fetch($stmt));

            // The if statment that checks so the user didn't change the html and try to delete a higher ranking person
            if ($deleted_user_rank >= $_SESSION['rank'])
            {
                header('Location: ../user_list.php?err=not-authorized'); 
                exit();
            }

            // Inserts the new users variables into the database.
            else{
                $sql = "DELETE FROM `RDL_users` WHERE `id` = ?;";
                $stmt = mysqli_stmt_init($conn);

                // Checking if there is a problem with the sql query.
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header('Location: ../user_list.php?err=sqlerr2');
                    exit();
                }

                // removes the user.
                else
                {
                    // Inserts the variables into the query.
                    mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
                    mysqli_stmt_execute($stmt);
                    /*mysqli_stmt_store_result($stmt);*/
                    header('Location: ../user_list.php?sus=user-deleted');
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// Sends back error message if the user didn't use the button to access the script.
else
{
    header('Location: ../user_list.php?err=Dont-even-try');
    exit();
}