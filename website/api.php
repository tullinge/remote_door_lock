<?php
require 'database/db_connection.php';

if (isset($_GET['id']))
{
    $sql = "SELECT `log_table`,`servo`,`toggle`,`delay_timer`,`act_timer`,`output_pin`,`led_pin`,`servo_extended`,`servo_retracted` FROM `RDL_esp32_config` WHERE `id`=".$_GET['id'].";";
    $result = mysqli_query($conn, $sql);

    while ($array = mysqli_fetch_array($result))
    {
        $config = [
            "log_table" => $array[0],
            "servo" => $array[1],
            "toggle" => $array[2],
            "delay_timer" => $array[3],
            "act_timer" => $array[4],
            "output_pin" => $array[5],
            "led_pin" => $array[6],
            "servo_extended" => $array[7],
            "servo_retracted" => $array[8],
        ];
    }

    $sql = "SELECT COUNT(*) FROM ".$config['log_table'].";";
    $result = mysqli_query($conn, $sql);

    while ($array = mysqli_fetch_array($result))
    {
        $rows = $array[0];
    }
    mysqli_close($conn);
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
    echo ',';
    echo $config['servo_extended'];
    echo ',';
    echo $config['servo_retracted'];
}

else
{
    echo "no id";
}
