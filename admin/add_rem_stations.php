<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';


echo "<!DOCTYPE html>
<html>
<head>
  <title>Processing ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';


$station_name = $_POST["username"] ?? '';
$userType = $_POST["userType"] ?? '';
$do = $_POST["do"] ?? '';
$no_of_platforms = $_POST["pltfno"] ?? '';
$state = $_POST["state"] ?? '';
$status = 'Active';

if ($do === 'ADD') {
    // Begin transaction
    pg_query($conn, "BEGIN");

    $counter_query = "SELECT counter FROM station_code_generator ORDER BY station_id DESC LIMIT 1";
    $counter_result = pg_query($conn, $counter_query);

    if ($counter_result) {
        $row = pg_fetch_assoc($counter_result);
        $counter = $row['counter'];

        $newCounter = $counter + 1;
        $updateCounter = "INSERT INTO station_code_generator (counter) VALUES ($newCounter)";
        $newResult = pg_query($conn, $updateCounter);

        if ($newResult) {
            $station_code = 'STN' . $counter;
        } else {
            // Rollback transaction
            pg_query($conn, "ROLLBACK");
            die("Error updating counter: " . pg_last_error($conn));
        }
    } else {
        // Rollback transaction
        pg_query($conn, "ROLLBACK");
        die("Error fetching counter: " . pg_last_error($conn));
    }

    $station_add_query = "INSERT INTO stations (station_code, station_name, no_of_platform, state, status) VALUES ($1, $2, $3, $4, $5);";
    $station_add_params = array($station_code, $station_name, $no_of_platforms, $state, $status);
    $station_add_execute = pg_query_params($conn, $station_add_query, $station_add_params);

    if ($station_add_execute) {
        // Commit transaction
        pg_query($conn, "COMMIT");
        echo '<script>window.alert("Station has been added Successfully with Station Code = ' . $station_code . '!!!"); window.location.href="ad_station_options.php";</script>';
    } else {
        // Rollback transaction
        pg_query($conn, "ROLLBACK");
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_add_station.php";</script>';
        echo "Error: " . pg_last_error($conn);
    }
} else if ($do === 'REM') {
    // Begin transaction
    pg_query($conn, "BEGIN");

    $check_query = "SELECT status FROM stations WHERE station_name = $1";
    $check_execute = pg_query_params($conn, $check_query, array($station_name));
    if($check_execute){
        $check_row = pg_fetch_assoc($check_execute);
        if($check_row['status'] === 'Active')
        {
            $rem_query = "UPDATE stations SET status='In-active' WHERE station_name = $1;";
            $rem_execute = pg_query_params($conn, $rem_query, array($station_name));

            if ($rem_execute) {
                $code_query = "SELECT station_code FROM stations WHERE station_name = $1";
                $code_result = pg_query_params($conn, $code_query, array($station_name));
                
                if ($code_result) {
                    $code_row = pg_fetch_assoc($code_result);
                    $station_code = $code_row['station_code'];
                    $status = 'In-active';

                    $start_query = "UPDATE routes SET status = $1 WHERE start_station = $2";
                    $start_result = pg_query_params($conn, $start_query, array($status, $station_code));
                    
                    if ($start_result) {
                        $end_query = "UPDATE routes SET status = $1 WHERE end_station = $2";
                        $end_result = pg_query_params($conn, $end_query, array($status, $station_code));
                        
                        if ($end_result) {
                            $tra_query = "UPDATE trains SET status = $1 WHERE route_code IN (SELECT route_code from routes WHERE status = 'In-active')";
                            $tra_result = pg_query_params($conn, $tra_query, array($status));

                            if($tra_result){
                                // Commit transaction
                                pg_query($conn, "COMMIT");
                                echo '<script>window.alert("Station has been removed Successfully!!!"); window.location.href="ad_station_options.php";</script>';
                            }else {
                                // Rollback transaction
                                pg_query($conn, "ROLLBACK");
                                die("Error updating routes end station status: " . pg_last_error($conn));
                            }
                            
                            
                        } else {
                            // Rollback transaction
                            pg_query($conn, "ROLLBACK");
                            die("Error updating routes end station status: " . pg_last_error($conn));
                        }
                    } else {
                        // Rollback transaction
                        pg_query($conn, "ROLLBACK");
                        die("Error updating routes start station status: " . pg_last_error($conn));
                    }
                } else {
                    // Rollback transaction
                    pg_query($conn, "ROLLBACK");
                    die("Error fetching station code: " . pg_last_error($conn));
                }
            } else {
                // Rollback transaction
                pg_query($conn, "ROLLBACK");
                echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_rem_station.php";</script>';
            }
        }
        else {
            // Rollback transaction
            pg_query($conn, "ROLLBACK");
            echo '<script>window.alert("Station is Already Not In Service !!!"); window.location.href="ad_rem_station.php";</script>';
        }
    }
    else {
        // Rollback transaction
        pg_query($conn, "ROLLBACK");
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_rem_station.php";</script>';
    }

} else if ($do === 'EDIT') {
    // Begin transaction
    pg_query($conn, "BEGIN");

    $station_code = $_POST["station_code"];
    $update_station = "UPDATE stations SET 
                station_name = $1,
                state = $2,
                no_of_platform = $3
                WHERE station_code = $4";

    $stmt = pg_prepare($conn, "update_query", $update_station);
    $result = pg_execute($conn, "update_query", array($station_name, $state, $no_of_platforms, $station_code));
    
    if ($result) {
        // Commit transaction
        pg_query($conn, "COMMIT");
        echo '<script>window.alert("Your Station is Successfully Updated !!!"); window.location.href="ad_station_options.php";</script>';
    } else {
        // Rollback transaction
        pg_query($conn, "ROLLBACK");
        echo "Error: " . pg_last_error($conn);
    }
} else if ($do === 'ACT'){
    pg_query($conn, "BEGIN");

    $check_query = "SELECT status FROM stations WHERE station_name = $1";
    $check_execute = pg_query_params($conn, $check_query, array($station_name));
    if($check_execute && pg_num_rows($check_execute) > 0){
        $check_row = pg_fetch_assoc($check_execute);
        if($check_row['status'] === 'In-active')
        {
            $act_query = "UPDATE stations SET status='Active' WHERE station_name = $1;";
            $act_execute = pg_query_params($conn, $act_query, array($station_name));

            if ($act_execute) {
                pg_query($conn, "COMMIT");
                echo '<script>window.alert("Station has been Activated Successfully!!!"); window.location.href="ad_station_options.php";</script>';
                          
            }else {
                // Rollback transaction
                pg_query($conn, "ROLLBACK");
                echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_act_station.php";</script>';
            }
        }
        else {
            // Rollback transaction
            pg_query($conn, "ROLLBACK");
            echo '<script>window.alert("Station is Already In Service !!!"); window.location.href="ad_act_station.php";</script>';
        }
    }else {
        // Rollback transaction
        pg_query($conn, "ROLLBACK");
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_act_station.php";</script>';
    }
}

pg_close($conn);
?>
