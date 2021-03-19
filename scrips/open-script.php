<?php
// Checks i f person got sent to the script file thrue the open button
if (isset($_POST['login-submit'])) {



else  {
    header('Location: ../index.php?err=Dont-be-a-dick);
    exit();
}