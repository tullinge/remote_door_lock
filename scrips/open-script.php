<?php
// Checks i f person got sent to the script file thrue the open button
if (isset($_POST['login-submit'])) {

    .$_SESSION['user_first_name'].
    .$_SESSION['user_last_name'].;
    .$_SESSION['user_email_address']

    $userid = $_POST['userid'];
    $userpassword = $_POST['userpassword'];

    if (empty($userid) || empty($userpassword)) {
        header('Location: ../index.php);
        exit();
    }


else  {
    header('Location: ../index.php?err=Dont-be-a-dick);
    exit();
}