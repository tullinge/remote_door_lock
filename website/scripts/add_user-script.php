<?php
include('../config.php');
require '../database/db_connection.php';

// Checks if person got sent to the script file thrue the open button.
if (isset($_POST['user-submit']))
{
    if ($_POST['rank'] == "")
    {
        $_POST['rank'] = "1";
    }
    if (empty($_POST['given_name']) || empty($_POST['family_name']) || empty($_POST['email']) || empty($_POST['rank']))
    {
       //Sends back user to fill out form again.
       header('Location: ../index.php?err=form-not-filled-out');
       exit(); 
    }
    else
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
            $sql = "INSERT INTO RDL_users (given_name, family_name, email, `rank`, added_by) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                // Sends back user if thear is a problem with sql querys sent to database.
                header('Location: ../index.php?err=sqlerr1');
               exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmt, 'sssis', strtolower($_POST['given_name']), strtolower($_POST['family_name']), strtolower($_POST['email']), $_POST['rank'], strtolower($_SESSION['email']));
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                // Sends back user if it succeeds to send data to database.
                if ($_POST['rank'] == 1)
                {
                    header('Location: ../index.php?sus=added-user');
                }
                elseif ($_POST['rank'] == 2)
                {
                    header('Location: ../index.php?sus=added-moderator');
                }
                elseif ($_POST['rank'] == 3)
                {
                    header('Location: ../index.php?sus=added-admin');
                }
                else
                {
                    header('Location: ../index.php?sus=added-user');
                }
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
else
{
    header('Location: ../index.php?err=Dont-even-try');
    exit();
}