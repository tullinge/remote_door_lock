<?php

if (isset($_POST['###'])) {

    require 'db_info.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $free_access = $_POST['free_access'];
    $site_admin = $_POST['site_admin'];
    $inactive = $_POST['inactive'];

    if (empty($first_name) || empty($last_name) || empty($email)){
        header('Location: ../###.php?err=emptyfields');
        exit();
    }

    else{

        $sql = 'SELECT * FROM users WHERE email=?';
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header('Location: ../###.php?err=sqlerr1');
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultcheck = mysqli_stmt_num_rows($stmt);

            if ($resultcheck > 0) {
                header('Location: ../'); 
                exit();
            }

            else{
                $sql = "INSERT INTO RDL_users (first_name, last_name, email, free_access, site_admin, inactive) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header('Location: ../###.php?err=sqlerr2');
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, 'sssiii', $first_name, $last_name, $email, $free_access, $site_admin, $inactive);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    header('Location: ../###.php?signup=success');
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
else  {
    header('Location: ../###.php?err=dont-be-a-dick');
    exit();
}