<?php
//Include configuration file.
include('../config.php');

// Require database file for database connecton.
require '../database/db_connection.php';

// Checks if person got sent to the script file thrue the open button.
if (isset($_POST['user-submit']))
{
    // If the user does not select the rank will be set to 1(User)
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
        // Define email of added user and compairs it to email template.
        $email_template_temp = str_replace('§given_name§', $_POST['given_name'], $email_template);
        $email_template_temp = str_replace('§family_name§', $_POST['family_name'], $email_template_temp);
        $email_template_temp = str_replace('§email_domain§', $email_domain, $email_template_temp);

        if (
            (
                strtolower(substr($email_restriction, 0, 1)) == 'y'
                && strtolower($email_template_temp) == strtolower($_POST['email'])
            )
            || strtolower(substr($email_restriction, 0, 1)) == 'n'
            || $_POST['rank'] == '3'
            || $_POST['rank'] == '4'
        )
        {
            //Sends back user if they artent properly loged in and loges them out.
            if (empty($_SESSION['given_name']) || empty($_SESSION['family_name']) || empty($_SESSION['email']))
            {
                require "logout-script.php";
                header('Location: ../index.php?err=not-logged-in-properly');
                exit();
            }
            else
            {
                // Defining sql query and initalizing a connectoin to the database.
                $sql = "SELECT * FROM RDL_users WHERE email=?;";
                $stmt = mysqli_stmt_init($conn);

                // Checking if their is a problem with the sql query.
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    // Sends back user if their is a problem with sql querys sent to database.
                    header('Location: ../index.php?err=sqlerr1');
                    exit();
                }

                // Checks so the email is not a duplicate.
                else
                {
                    // Inputs the email as an argument to find rank.
                    mysqli_stmt_bind_param($stmt, 's', strtolower($_POST['email']));
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultcheck = mysqli_stmt_num_rows($stmt);

                    // The if statment that checks if the email added is a duplicate.
                    if ($resultcheck > 0)
                    {
                        // Sends back error message that user already exist.
                        header('Location: ../index.php?err=already-exist'); 
                        exit();
                    }

                    // Inserts the new users variables into the database.
                    else
                    {
                        // Defining sql query and initalizing a connectoin to the database.
                        $sql = "INSERT INTO RDL_users (given_name, family_name, email, `rank`, added_by) VALUES (?, ?, ?, ?, ?)";
                        $stmt = mysqli_stmt_init($conn);

                        // Checking if their is a problem with the sql query.
                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                            header('Location: ../index.php?err=sqlerr2');
                            exit();
                        }

                        // Adds the user
                        else
                        {
                            // Inserts the variables into the query.
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
                }
            }
        }
        // Sends back error message if the user didn't use the correct template for the new users email/name.
        else
        {
            header('Location: ../index.php?err=email-template-not-match');
            exit();
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
// Sends back error message if the user didnt use the button to access the script.
else
{
    header('Location: ../index.php?err=Dont-even-try');
    exit();
}