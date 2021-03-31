<?php
include('../config.php');
require '../database/db_connection.php';

// Checks if person got sent to the script file thru the open button in the index file.
if (isset($_POST['delete_user-submit']))
{

    $sql = 'SELECT `rank` FROM RDL_users WHERE id=?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header('Location: ../user_list.php?err=sqlerr1');
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $deleted_user_rank);
        while (mysqli_stmt_fetch($stmt));

        if ($deleted_user_rank >= $_SESSION['rank'])
        {
            header('Location: ../user_list.php?err=not-authorized'); 
            exit();
        }

        else{
            $sql = "DELETE FROM `RDL_users` WHERE `id` = ?;";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header('Location: ../user_list.php?err=sqlerr2');
                exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
                mysqli_stmt_execute($stmt);
                /*mysqli_stmt_store_result($stmt);*/
                header('Location: ../user_list.php?sus=user-deleted');
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else
{
    header('Location: ../user_list.php?err=Dont-even-try');
    exit();
}