<html>
    <!-- Linking to css files -->
    <head>
        <title>RDL User list</title>
        <link rel="stylesheet" href="website_structure/root.css">
        <link rel="stylesheet" href="website_structure/user_list.css">
    </head>
    <?php
        include 'website_structure/header.php';
    ?>
    <body>
    <form method="post">
        <input type="text" placeholder="search_parameter" name="search_parameter">
        <button type="submit" name="search_parameter-submit"><p>SEARCH</p></button>
    </form>
    <?php
        //Include configuration file.
        include('config.php');

        // Require database file for database connecton.
        require 'database/db_connection.php';
        // Checks if person got sent to the script file through the open button in the index file.
        if ($_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
        {
            // defines the sql query and sends it.
            $users = [];
            $sql = "SELECT `id`,`given_name`,`family_name`,`email`,`rank`,`added_by` FROM `RDL_users` WHERE `rank` < ".$_SESSION['rank']." ORDER BY `family_name` ASC, `given_name` ASC;";
            $result = mysqli_query($conn, $sql);

            // Fetches and saves the user info in an array to be printed from.
            while ($array = mysqli_fetch_array($result))
            {
                $user = [
                    "id" => $array[0],
                    "given_name" => $array[1],
                    "family_name" => $array[2],
                    "email" => $array[3],
                    "rank" => $array[4],
                    "added_by" => $array[5],
                ];
                array_push($users, $user);
            }
            mysqli_close($conn);

            if (isset($_POST['search_parameter-submit']) && $_POST['search_parameter'] != '')
            {
                $i = 0;
                foreach ($users as $user)
                {
                    
                    $full_name = $user['given_name'].' '.$user['family_name'];
                    $full_name_reversed = $user['family_name'].' '.$user['given_name'];
                    // Checks all diffrent parameters as parts off first/last/email
                    if (
                            strpos($full_name, $_POST['search_parameter']) !== false 
                            || strpos($full_name_reversed, $_POST['search_parameter']) !== false 
                            || strpos($user['given_name'], $_POST['search_parameter']) !== false 
                            || strpos($user['family_name'], $_POST['search_parameter']) !== false 
                            || strpos($user['email'], $_POST['search_parameter']) !== false
                        )
                    {
                        
                    }
                    else
                    {
                        unset($users[$i]);
                    }
                    $i += 1;
                }
            }

            // Echos the list of users one user at a time.
            foreach ($users as $user)
            {
                // CSS
                echo '
                    <style>
                        .grid_user_'.$user['id'].'_name
                        {
                            grid-area: grid_name;
                            margin: auto;
                        }
                        .grid_user_'.$user['id'].'_email
                        {
                            grid-area: grid_email;
                            margin: auto;
                        }
                        .grid_user_'.$user['id'].'_rank
                        {
                            grid-area: grid_rank;
                            margin: auto;
                        }
                        .grid_user_'.$user['id'].'_added_by
                        {
                            grid-area: grid_added_by;
                            margin: auto;
                        }
                        .grid_user_'.$user['id'].'_delete_form
                        {
                            grid-area: grid_delete_form;
                            margin: auto;
                        }
                        .grid_user_'.$user['id'].'_update_form
                        {
                            grid-area: grid_update_form;
                            margin: auto;
                        }

                        .grid_user_'.$user['id'].'_wrapper {
                            background-color: hsl(0, 0%, 85%);
                            display: grid;
                            width: 100%;
                            height: 4vw;
                            margin-top: 1vw;
                            margon-bottom: 1vw;
                            grid-gap: .5vw;
                            grid-template-rows: 1fr 1fr;
                            grid-template-columns: 3fr 6fr 3fr 20fr 8fr;
                            grid-template-areas:
                            "grid_name grid_email grid_rank . grid_added_by"
                            ". grid_delete_form grid_update_form grid_update_form grid_update_form";
                        }
                    </style>
                ';

                // User HTML
                echo '
                    <div class="grid_user_'.$user['id'].'_wrapper">
                        <div class="grid_user_'.$user['id'].'_name">
                            <p class="name">'.$user['given_name'].' '.$user['family_name'].'</p>
                        </div>
                        <div class="grid_user_'.$user['id'].'_email">
                            <p> '.$user['email'].'</p>
                        </div>
                    
                ';
                if ($user['rank'] == 1)
                {
                    echo '
                        <div class="grid_user_'.$user['id'].'_rank">
                            <p>User</p>
                        </div>
                    ';
                }
                
                else if ($user['rank'] == 2)
                {
                    echo '
                        <div class="grid_user_'.$user['id'].'_rank">    
                            <p>Moderator</p>
                        </div>
                    ';
                }
                else if ($user['rank'] == 3)
                {
                    echo '
                        <div class="grid_user_'.$user['id'].'_rank">
                            <p>Admin</p>
                        </div>
                    ';
                }

                // Checks if the person is admin or fallback admin and if they are shown the email of the person that added them.
                if($_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
                {
                    echo '
                        <div class="grid_user_'.$user['id'].'_added_by">
                            <p>Added by: '.$user['added_by'].'</p>
                        </div>
                    ';
                }
                // Adds form and button to delete user.
                echo '
                    <div class="grid_user_'.$user['id'].'_delete_form">
                        <form action="scripts/delete_user-script.php" method="post">
                            <input type="hidden" name="id" value="'.$user['id'].'">
                            <button type="submit" name="delete_user-submit" class="remove_user_button"><p>REMOVE USER</p></button>
                        </form>
                    </div>
                    <div class="grid_user_'.$user['id'].'_update_form">
                    <form action="scripts/update_user-script.php" method="post">
            ';

                if ($_SESSION['rank'] == '4')
                {
                    echo '
                        <input type="text" value="'.$user['given_name'].'" placeholder="given_name" name="given_name">
                        <input type="text" value="'.$user['family_name'].'" placeholder="family_name" name="family_name">
                        <input type="text" value="'.$user['email'].'" placeholder="email" name="email">
                    ';
                }

                if ($user['rank'] == '1')
                {
                    echo '<input type="radio" id="user_'.$user['id'].'" name="rank" value="1" checked="checked">';
                }
                else
                {
                    echo '<input type="radio" id="user_'.$user['id'].'" name="rank" value="1">';
                }
                echo '<label for="user_'.$user['id'].'">USER</label>';

                if ($user['rank'] == '2')
                {
                    echo '<input type="radio" id="moderator_'.$user['id'].'" name="rank" value="2" checked="checked">';
                }
                else
                {
                    echo '<input type="radio" id="moderator_'.$user['id'].'" name="rank" value="2">';
                }
                echo '<label for="moderator_'.$user['id'].'">MODERATOR</label>';

                if ($user['rank'] == '3')
                {
                    echo '<input type="radio" id="admin_'.$user['id'].'" name="rank" value="3" checked="checked">';
                }
                else
                {
                    echo '<input type="radio" id="admin_'.$user['id'].'" name="rank" value="3">';
                }
                echo '
                                <label for="admin_'.$user['id'].'">ADMIN</label>
                                <input type="hidden" name="id" value="'.$user['id'].'">
                                <button type="submit" name="update_user-submit"><p>UPDATE USER</p></button>
                            </form>
                        </div>
                    </div>
                ';
            }

        }
        // Sends back error message if the user didn't use the button to access the script.
        else
        {
            header('Location: ../index.php?err=Dont-even-try');
            exit();
        }
    ?>
    </body>
    <?php
        include 'website_structure/footer.php';
    ?>
</html>
