<?php
include('../config.php');

require '../index.php';

require '../database/db_connection.php';

// Checks i f person got sent to the script file thrue the open button
if (isset($_POST['open-submit'])) {

    if (empty($given_name) || empty($family_name) || empty($email)) {
        //Destroy entire session data.s
        session_destroy();
        header('Location: ../index.php?err=not-loged-in-properly');
        exit();
    }
    else {
        $sql = "INSERT INTO RDL_log (given_name, family_name, email) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header('Location: ../index.php?err=sqlerr1');
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, 'sss', $given_name, $family_name, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            header('Location: ../index.php?sus=door-opened');
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
 
}
else  {
    header('Location: ../index.php?err=Dont-even-try');
    exit();
}