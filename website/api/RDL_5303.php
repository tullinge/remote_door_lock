<?php
require '../database/db_connection.php';

if (isset($_GET['id']))
{
    $sql = "SELECT * FROM `RDL_esp32_config` WHERE `id`=".$_GET['id'].";";
    $result = mysqli_query($conn, $sql);

    while ($array = mysqli_fetch_array($result))
    {
        $config = [
            "id" => $array[0],
            "log_tabel" => $array[1],
            "servo" => $array[2],
            "toggle" => $array[3],
            "delay_timer" => $array[4],
            "act_timer" => $array[5],
            "output_pin" => $array[6],
            "led_pin" => $array[7],
        ];
    }

    $sql = "SELECT COUNT(*) FROM ".$config['log_tabel'].";";
    $result = mysqli_query($conn, $sql);

    while ($array = mysqli_fetch_array($result))
    {
        $rows = $array[0];
    }
    mysqli_close($conn);
}

echo $rows;
echo ',';
echo $config['servo'];
echo ',';
echo $config['toggle'];
echo ',';
echo $config['delay_timer'];
echo ',';
echo $config['act_timer'];
echo ',';
echo $config['output_pin'];
echo ',';
echo $config['led_pin'];