<?php
//Include configuration file.
require 'config.php';

// Require Databes file for database connecton.
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
        // Set the access token used for requests
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
}

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
 //Create a URL to obtain user authorization.
 $login_button = '<a href="'.$google_client->createAuthUrl().'"><p>Login</p></a>';
}

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
            include 'website_structure/header.php';
            require 'scripts/error_checking-script.php';

            $sql = "SELECT `rank` FROM RDL_users WHERE `email` = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                // Sends back user if thear is a problem with sql querys sent to database.
                header('Location: ../index.php?err=sqlerr1');
                exit();    
            }
            else
            {
                mysqli_stmt_bind_param($stmt, 's', strtolower($_SESSION['email']));
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $_SESSION['rank']);
                if (mysqli_stmt_fetch($stmt));
                {
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            if($login_button == '')
            {
                if($_SESSION['rank'] == '1' || $_SESSION['rank'] == '2' || $_SESSION['rank'] == '3' || $_SESSION['rank'] == '4') {
                    echo '<img src="'.$_SESSION["picture"].'" class="img-responsive img-circle img-thumbnail" />';
                    echo '<p>Name : '.$_SESSION['given_name'].' '.$_SESSION['family_name'].'</p>';

                    // A logout button.
                    echo '<form action="scripts/logout-script.php" method="post">';
                    echo '<button type="submit" name="logout-submit"><p>LOGOUT</p></button>';
                    echo '</form>';

                    // A button that sends a request to open the door.
                    echo '<form action="scripts/request-script.php" method="post">';
                    echo '<button type="submit" name="request-submit"><p>OPEN DOOR</p></button>';
                    echo '</form>';

                    // Adds a user add form for moderator, admins and fallbackadmin.
                    if($_SESSION['rank'] == '2' || $_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
                    {
                        echo '<form action="scripts/add_user-script.php" method="post">';
                        echo '<input type="text" placeholder="given_name" name="given_name">';
                        echo '<input type="text" placeholder="family_name" name="family_name">';
                        echo '<input type="text" placeholder="email" name="email">';
                        
                        // Adds the option for admins adn fallbackadmins too select what rank a new user is supose to have.
                        if($_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
                        {
                            echo '<input type="radio" id="user" value="1" name="rank">';
                            echo '<label for="user">User</label>';
                            echo '<input type="radio" id="moderator" value="2" name="rank">';
                            echo '<label for="moderator">Moderator</label>';
                            echo '<input type="radio" id="admin" value="3" name="rank">';
                            echo '<label for="admin">Admin</label>';
                        }

                        // A button to add user email, first and lastname to the database
                        echo '<button type="submit" name="user-submit">ADD USER</button>';
                        echo '</form>';
                    }

                    // Shows admins and fallbackadmins a list of all users bellow thear rank.
                    if ($_SESSION['rank'] == '3'|| $_SESSION['rank'] == '4')
                    {
                        // A button that sends a request to open the door.
                        echo '<form action="user_list.php" method="post">';//scripts/list_users-script.php
                        echo '<button type="submit" name="list_users-submit"><p>USER LIST</p></button>';
                        echo '</form>';
                    }
                }

                // Logs a person out if they dont have a rank/do not exist in the database.
                else 
                {   
                    $google_client->revokeToken($_SESSION['access_token']);
                    session_destroy();
                    header('Location: ../index.php?err=no-access');
                    exit();
                }
            }
            else
            {
                echo '<div>'.$login_button . '</div*>';
            }

            include 'website_structure/footer.php';
        ?>
    </body>
</html>