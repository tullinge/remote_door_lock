<?php

// Require configuration file.
require 'config.php';

// Require database file for database connecton.
require 'database/db_connection.php';

$login_button = '';

// This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
    // It will Attempt to exchange a code for an valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
    if(!isset($token['error']))
    {
        // Set the access token used for requests.
        $google_client->setAccessToken($token['access_token']);

        // Store "access_token" value in $_SESSION variable for future use.
        $_SESSION['access_token'] = $token['access_token'];

        // Create Object of Google Service OAuth 2 class.
        $google_service = new Google_Service_Oauth2($google_client);

        // Get user profile data from google.
        $data = $google_service->userinfo->get();

        // Below you can find Get profile data and store into $_SESSION variable.
        if(!empty($data['given_name']))
        {
            $_SESSION['given_name'] = $data['given_name'];
        }
        if(!empty($data['family_name']))
        {
            $_SESSION['family_name'] = $data['family_name'];
        }
        if(!empty($data['email']))
        {
            $_SESSION['email'] = $data['email'];
        }
        if(!empty($data['picture']))
        {
            $_SESSION['picture'] = $data['picture'];
        }
    }
    header('Location: ../index.php?');
}

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
 //Create a URL to obtain user authorization.
 $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="website_structure/img/btn_google_signin_dark_normal_web.png"></a>';
}

$email_template_temp = str_replace($_SESSION['given_name'], '§given_name§', $email_template);
$email_template_temp = str_replace($_SESSION['family_name'], '§family_name§', $email_template_temp);
$email_template_temp = str_replace($email_domain, '§email_domain§', $email_template_temp);

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>RDL</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    </head>
    <body>
        <?php
            // Importing standardized header.
            include 'website_structure/header.php';

            // Checking for error scripts.
            require 'scripts/error_checking-script.php';

            // Defining sql query and initalizing a connectoin to the database.
            $sql = "SELECT `rank` FROM RDL_users WHERE `email` = ?";
            $stmt = mysqli_stmt_init($conn);

            // Checking if their is a problem with the sql query.
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                // Sends back user if their is a problem with sql querys sent to database.
                header('Location: ../index.php?err=sqlerr1');
                exit();
            }

            // Checks what rank the user have.
            else
            {
                // Inputs the email as an argument to find rank.
                mysqli_stmt_bind_param($stmt, 's', strtolower($_SESSION['email']));
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $_SESSION['rank']);
                if (mysqli_stmt_fetch($stmt));
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            // Checking if the login button is pressed.
            if ($login_button == '')
            {
                if (
                    (
                        strtolower(substr($email_restriction, 0, 1)) == 'y'
                        && strtolower($email_template_temp) == $_SESSION['email']
                    )
                    || strtolower(substr($email_restriction, 0, 1)) == 'n'
                    || $_SESSION['rank'] == '3'
                    || $_SESSION['rank'] == '4'
                )
                {
                    // Checks so the user have an appropriate rank.
                    if($_SESSION['rank'] == '1' || $_SESSION['rank'] == '2' || $_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
                    {
                        echo '
                            <img src="'.$_SESSION["picture"].'" class="img-responsive img-circle img-thumbnail" />
                            <p>Name : '.$_SESSION['given_name'].' '.$_SESSION['family_name'].'</p>
                        ';

                        // A logout button.
                        echo '
                            <form action="scripts/logout-script.php" method="post">
                                <button type="submit" name="logout-submit">
                                    <p>LOGOUT</p>
                                </button>
                            </form>
                        ';

                        // A button that sends a request to open the door.
                        echo '
                            <form action="scripts/request-script.php" method="post">
                                <button type="submit" name="request-submit">
                                    <p>OPEN DOOR</p>
                                </button>
                            </form>
                        ';

                        // Adds a user add form for moderator, admins and fallbackadmin.
                        if($_SESSION['rank'] == '2' || $_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
                        {
                            echo '
                                <form action="scripts/add_user-script.php" method="post">
                                    <input type="text" placeholder="given_name" name="given_name">
                                    <input type="text" placeholder="family_name" name="family_name">
                                    <input type="text" placeholder="email" name="email">
                            ';
                            
                            // Adds the option for admins adn fallbackadmins too select what rank a new user is supose to have.
                            if($_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
                            {
                                echo '
                                    <input type="radio" id="user" value="1" name="rank">
                                    <label for="user">User</label>
                                    <input type="radio" id="moderator" value="2" name="rank">
                                    <label for="moderator">Moderator</label>
                                    <input type="radio" id="admin" value="3" name="rank">
                                    <label for="admin">Admin</label>
                                ';
                            }

                            // A button to add user email, first and lastname to the database.
                            echo '
                                    <button type="submit" name="user-submit">ADD USER</button>
                                </form>
                            ';
                        }

                        // Shows admins and fallbackadmins a list of all users bellow their rank.
                        if ($_SESSION['rank'] == '3'|| $_SESSION['rank'] == '4')
                        {
                            // A button that sends you to the user list page.
                            echo '
                                <form action="user_list.php" method="post">
                                    <button type="submit" name="list_users-submit"><p>USER LIST</p></button>
                                </form>
                            ';
                        }
                        // Shows fallbackadmins a list of all units.
                        if ($_SESSION['rank'] == '4')
                        {
                            // A button that sends you to the unit list page.
                            echo '
                                <form action="unit_list.php" method="post">
                                    <button type="submit" name="list_units-submit"><p>UNIT LIST</p></button>
                                </form>
                            ';
                        }
                    }

                    // Logs a person out if they dont have a rank/do not exist in the database.
                    else 
                    {   
                        require "scripts/logout-script.php";
                        header('Location: ../index.php?err=no-access');
                        exit();
                    }
                }
                else
                {
                    require "scripts/logout-script.php";
                    header('Location: ../index.php?err=no-access');
                    exit();
                }
            }
            else
            {
                echo '<div>'.$login_button . '</div>';
            }

            // Importing standardized footer.
            include 'website_structure/footer.php';
        ?>
    </body>
</html>