<?php
//Include configuration file.
include('../config.php');

// Require database file for database connecton.
require '../database/db_connection.php';

// Checks if person got sent to the script file thru the open button in the index file.
if (isset($_POST['delete_unit-submit']))
{
    //Sends back unit if they artent properly logged in and logs them out.
    if (empty($_SESSION['given_name']) || empty($_SESSION['family_name']) || empty($_SESSION['email']))
    {
        require "scripts/logout-script.php";
        header('Location: ../index.php?err=not-loged-in-properly');
        exit();
    }
    else
    {
        // remove the units from the database.
        if ($_SESSION['rank'] == '4')
        {
            $sql = "DELETE FROM `RDL_esp32_config` WHERE `id` = ?;";
            $stmt = mysqli_stmt_init($conn);

            // Checking if there is a problem with the sql query.
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header('Location: ../unit_list.php?err=sqlerr2');
                exit();
            }

            // removes the unit.
            else
            {
                // Inserts the variables into the query.
                mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
                mysqli_stmt_execute($stmt);
                /*mysqli_stmt_store_result($stmt);*/
                header('Location: ../unit_list.php?sus=unit-deleted');
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// Sends back error message if the unit didn't use the button to access the script.
else
{
    header('Location: ../unit_list.php?err=Dont-even-try');
    exit();
}