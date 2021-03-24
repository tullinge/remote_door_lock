<?php
require '../database/db_connection.php';

$sql = "SELECT * FROM RDL_log";
$stmt = mysqli_stmt_init($conn);

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    echo mysqli_stmt_num_rows($stmt);
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);