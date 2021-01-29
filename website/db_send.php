<?php

if (isset($_POST['request-send'])) {
    require 'db_info.php';

    $user = $_POST['userid'];
    $userpassword = $_POST['userpassword'];

    if (empty($userid) || empty($userpassword) || empty($userpasswordrepeat)){
        header('Location: ../signup.php?err=emptyfields&userid='.$userid);
        exit();
    }

}
