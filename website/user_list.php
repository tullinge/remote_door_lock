<html>
    <?php
        include 'website_structure/header.php';
    ?>
    <body>
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
            $sql = "SELECT `id`,`given_name`,`family_name`,`email`,`added_by` FROM RDL_users WHERE `rank` < ".$_SESSION['rank']." ORDER BY `family_name` ASC, `given_name` ASC;";
            $result = mysqli_query($conn, $sql);

            // Fetches and saves the user info in an array to be printed from.
            while ($array = mysqli_fetch_array($result))
            {
                $user = [
                    "id" => $array[0],
                    "given_name" => $array[1],
                    "family_name" => $array[2],
                    "email" => $array[3],
                    "added_by" => $array[4],
                ];
                array_push($users, $user);
            }
            mysqli_close($conn);
            // Echos the list of users one user at a time.
            foreach ($users as $user) {
                echo '
                    <br>'.$user['given_name'].' '.$user['family_name'].'
                    <br>'.$user['email'].'<br>
                ';

                // Checks if the person is admin or fallback admin and if they are shown the email of the person that added them.
                if($_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
                {
                    echo '
                       <p>Added by: '.$user['added_by'].'</p>
                    ';
                }
                // Adds form and button to delete user.
                echo '
                    <form action="scripts/delete_user-script.php" method="post">
                        <input type="hidden" name="id" user="'.$user['id'].'">
                        <button type="submit" name="delete_user-submit"><p>REMOVE USER</p></button>
                    </form>
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
