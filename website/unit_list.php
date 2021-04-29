<html>
    <!-- Linking to css files -->
    <head>
        <link rel="stylesheet" href="website_structure/root.css">
        <link rel="stylesheet" href="website_structure/unit_list.css">
    </head>
    <?php
        include 'website_structure/header.php';
    ?>
    <body>
    <form method="post">
        <input type="text" placeholder="search_parameter" name="search_parameter">
        <button type="submit" name="search_parameter-submit"><p>SEARCH</p></button>
    </form>
    <?php
        //Include configuration file.
        include('config.php');

        // Require database file for database connecton.
        require 'database/db_connection.php';
        // Checks if person got sent to the script file through the open button in the index file.
        if ($_SESSION['rank'] == '4')
        {
            // defines the sql query and sends it.
            $units = [];
            $sql = "SELECT `id`, `unit_name`, `log_table`, `servo`, `toggle`, `delay_timer`, `act_timer`, `output_pin`, `led_pin`,`servo_extended`,`servo_retracted` FROM RDL_esp32_config ORDER BY `id` ASC;";
            $result = mysqli_query($conn, $sql);

            // Fetches and saves the unit info in an array to be printed from.
            while ($array = mysqli_fetch_array($result))
            {
                $unit = [
                    "id" => $array[0],
                    "unit_name" => $array[1],
                    "log_table" => $array[2],
                    "servo" => $array[3],
                    "toggle" => $array[4],
                    "delay_timer" => $array[5],
                    "act_timer" => $array[6],
                    "output_pin" => $array[7],
                    "led_pin" => $array[8],
                    "servo_extended" => $array[9],
                    "servo_retracted" => $array[10],
                ];
                array_push($units, $unit);
            }
            mysqli_close($conn);

            if (isset($_POST['search_parameter-submit']) && $_POST['search_parameter'] != '')
            {
                $i = 0;
                foreach ($units as $unit)
                {
                    if (
                            ($_POST['search_parameter'] == $unit['id']
                            || strpos($unit['unit_name'], $_POST['search_parameter']) !== false
                            || strpos($unit['log_table'], $_POST['search_parameter']) !== false
                            )
                        )
                    {
                        
                    }
                    else
                    {
                        unset($units[$i]);
                    }
                    $i += 1;
                }
            }

            // Echos the list of units one unit at a time.
            foreach ($units as $unit)
            {
                // CSS
                echo '
                    <style>
                        .grid_unit_'.$unit['id'].'_id
                        { 
                            grid-area: grid_id;
                            margin: auto;
                        }
                        .grid_unit_'.$unit['id'].'_unit_name
                        {
                            grid-area: grid_unit_name;
                            margin: auto;
                        }
                        .grid_unit_'.$unit['id'].'_log_table
                        {
                            grid-area: grid_log_table;
                            margin: auto;
                        }
                        .grid_unit_'.$unit['id'].'_delete_form
                        {
                            grid-area: grid_delete_form;
                            margin: auto;
                        }
                        .grid_unit_'.$unit['id'].'_update_form
                        {
                            grid-area: grid_update_form;
                            margin: auto;
                        }
                        
                        .grid_unit_'.$unit['id'].'_wrapper {
                            background-color: hsl(0, 0%, 85%);
                            display: grid;
                            width: 100%;
                            height: 4vw;
                            margin-top: 1vw;
                            margon-bottom: 1vw;
                            grid-gap: .5vw;
                            grid-template-rows: 1fr 1fr;
                            grid-template-columns: 2fr 3fr 3fr 30fr;
                            grid-template-areas:
                            "grid_id grid_unit_name grid_log_table grid_update_form"
                            ". grid_delete_form . grid_update_form";
                        }
                    </style>
                ';
                // Adds form and button to delete unit.
                echo '
                    <div class="grid_unit_'.$unit['id'].'_wrapper">
                    <div class="grid_unit_'.$unit['id'].'_id">
                        <p>id:'.$unit['id'].'</p>
                    </div>
                        <div class="grid_unit_'.$unit['id'].'_unit_name">
                            <p>'.$unit['unit_name'].'</p>
                        </div>
                        <div class="grid_unit_'.$unit['id'].'_log_table">
                            <p>'.$unit['log_table'].'</p>
                        </div>
                        <div class="grid_unit_'.$unit['id'].'_delete_form">
                            <form action="scripts/delete_unit-script.php" method="post">
                                <input type="hidden" name="id" value="'.$unit['id'].'">
                                <button type="submit" name="delete_unit-submit"><p>REMOVE UNIT</p></button>
                            </form>
                        </div>
                        <div class="grid_unit_'.$unit['id'].'_update_form">
                            <form action="scripts/update_unit-script.php" method="post">
                                <div class="row_1_inputs">
                                    <label for="unit_name">unit_name</label>
                                    <input type="text" id="unit_name" value="'.$unit['unit_name'].'" placeholder="unit_name" name="unit_name">
                                    <label for="log_table">log_table</label>
                                    <input type="text" id="log_table" value="'.$unit['log_table'].'" placeholder="log_table" name="log_table">
                                    <label for="delay_timer">delay_timer</label>
                                    <input type="number" id="delay_timer" value="'.$unit['delay_timer'].'" placeholder="delay_timer" name="delay_timer">
                                    <label for="act_timer">act_timer</label>
                                    <input type="number" id="act_timer" value="'.$unit['act_timer'].'" placeholder="act_timer" name="act_timer">
                                </div>
                                <div class="row_2_inputs">
                                    <label for="output_pin">output_pin</label>
                                    <input type="number" id="output_pin" value="'.$unit['output_pin'].'" placeholder="output_pin" name="output_pin">
                                    <label for="led_pin">led_pin</label>
                                    <input type="number" id="led_pin" value="'.$unit['led_pin'].'" placeholder="led_pin" name="led_pin">
                                    <label for="servo_extended">servo_extended</label>
                                    <input type="number" id="servo_extended" value="'.$unit['servo_extended'].'" placeholder="servo_extended" name="servo_extended">
                                    <label for="servo_retracted">servo_retracted</label>
                                    <input type="number" id="servo_retracted" value="'.$unit['servo_retracted'].'" placeholder="servo_retracted" name="servo_retracted">
                                    <label for="servo">servo</label>
                ';

                if ($unit['servo'] == '1')
                {
                    echo '<input type="checkbox" id="servo" name="servo" value="1" checked="checked">';
                }
                else
                {
                    echo '<input type="checkbox" id="servo" name="servo" value="1">';
                }
                
                echo '<label for="toggle">toggle</label>';
                if ($unit['toggle'] == '1')
                {
                    echo '<input type="checkbox" id="toggle" name="toggle" value="1" checked="checked">';
                }
                else
                {
                    echo '<input type="checkbox" id="toggle" name="toggle" value="1">';
                }

                echo '
                                    <input type="hidden" name="id" value="'.$unit['id'].'">
                                    <button type="submit" name="update_unit-submit"><p>UPDATE UNIT</p></button>
                                </div>
                            </form>
                        </div>
                    </div>
                ';
            }

        }
        // Sends back error message if the unit didn't use the button to access the script.
        else
        {
            header('Location: ../index.php?err=Dont-even-try');
            exit();
        }
    ?>
    </body>
    <?php
        include 'website_structure/footer.php';
    ?>
</html>
