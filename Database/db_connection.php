<?php

require 'db_info.php';

$conn = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASSWORD,
    $DATABASE_NAME,
);

if (!$conn) {
    die('connection failed:' .mysqli_connect_error());
}