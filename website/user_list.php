<html>
    <head>
    </head>
    <body>
    <?php
        include('config.php');
        require 'database/db_connection.php';
        // Checks if person got sent to the script file thru the open button in the index file.
        if ($_SESSION['rank'] == '3' || $_SESSION['rank'] == '4')
        {
            $users = [];
            $sql = "SELECT `id`,`given_name`,`family_name`,`email` FROM RDL_users WHERE `rank` < ".$_SESSION['rank'].";";
            $result = mysqli_query($conn, $sql);
            while ($array = mysqli_fetch_array($result))
            {
                $user = [
                    "id" => $array[0],
                    "given_name" => $array[1],
                    "family_name" => $array[2],
                    "email" => $array[3],
                ];
                array_push($users, $user);
            }
            mysqli_close($conn);
            //Prepers and lists result
            foreach ($users as $value) {
                echo '<br>'.$value['given_name'].' '.$value['family_name'];
                echo '<br>'.$value['email'].'<br>';
                echo '
                    <form action="scripts/delete_user-script.php" method="post">
                        <input type="hidden" name="id" value="'.$value['id'].'">
                        <button type="submit" name="delete_user-submit"><p>REMOVE USER</p></button>
                    </form>
                ';
            }

        }
        else
        {
            header('Location: ../index.php?err=Dont-even-try');
            exit();
        }
    ?>
    </body>
</html>
