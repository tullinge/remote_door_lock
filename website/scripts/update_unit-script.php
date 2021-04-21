<?php
//Include configuration file.
include('../config.php');

// Require database file for database connecton.
require '../database/db_connection.php';

// Checks if person got sent to the script file thru the open button in the index file.
if (isset($_POST['update_unit-submit']))
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
        // Defining sql query and initalizing a connection to the database.
        $sql = 'SELECT `unit_name`, `log_table`, `servo`, `toggle`, `delay_timer`, `act_timer`, `output_pin`, `led_pin` FROM RDL_esp32_configs WHERE `id` = ?;';
        $stmt = mysqli_stmt_init($conn);

        // Checking if their is a problem with the sql query.
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            // Sends back unit if there is a problem with sql querys sent to database.
            header('Location: ../unit_list.php?err=sqlerr1');
            exit();
        }

        else
        {
            // Inputs the id of the unit into the query.
            mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $unit_name, $log_table, $servo, $toggle, $delay_timer, $act_timer, $output_pin, $led_pin);
            while (mysqli_stmt_fetch($stmt));

            // Checks if any of the boxes are empty. If any of the boxes are empty they will not change anything
            if (empty($_POST['unit_name']))
            {
                $_POST['unit_name'] = $unit_name;
            }

            if (empty($_POST['log_table']))
            {
                $_POST['log_table'] = $log_table;
            }

            if (empty($_POST['servo']))
            {
                $_POST['servo'] = $servo;
            }

            if (empty($_POST['toggle']))
            {
                $_POST['toggle'] = $toggle;
            }

            if (empty($_POST['delay_timer']))
            {
                $_POST['delay_timer'] = $delay_timer;
            }

            if (empty($_POST['act_timer']))
            {
                $_POST['act_timer'] = $act_timer;
            }

            if (empty($_POST['output_pin']))
            {
                $_POST['output_pin'] = $output_pin;
            }

            if (empty($_POST['led_pin']))
            {
                $_POST['led_pin'] = $led_pin;
            }

            // The if statment that checks so the unit didn't change the html and try to delete a higher ranking person
            if ($rank >= $_SESSION['rank'])
            {
                header('Location: ../unit_list.php?err=not-authorized'); 
                exit();
            }

            // Inserts the new units variables into the database.
            else{
                $sql = "UPDATE `RDL_esp32_config` SET `unit_name`=?, `log_table`=?, `servo`=?, `toggle`=?, `delay_timer`=?, `act_timer`=?, `output_pin`=?, `led_pin`=? WHERE `id` = ?;";
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
                    mysqli_stmt_bind_param($stmt, 'sssii', $_POST['unit_name'], $_POST['log_table'], $_POST['servo'], $_POST['toggle'], $_POST['delay_timer'], $_POST['act_timer'], $_POST['output_pin'], $_POST['led_pin'], $_POST['id']);
                    mysqli_stmt_execute($stmt);
                    /*mysqli_stmt_store_result($stmt);*/
                    header('Location: ../unit_list.php?sus=unit-updated');
                    exit();
                }
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