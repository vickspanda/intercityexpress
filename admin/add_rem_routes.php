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


$from_station = $_POST["from_station"] ?? '';
$to_station = $_POST["to_station"] ?? '';
$time_taken = $_POST["r_time"] ?? '';
$dist = $_POST["r_dist"] ?? '';
$do = $_POST["do"] ?? '';
$status = 'Active';
$time_taken = $time_taken . ' hours';
if ($do === 'ADD') {
    $get_from = "SELECT station_code FROM stations WHERE station_name = $1";
    $get_from_result = pg_query_params($conn, $get_from, array($from_station));
    if ($get_from_result) {
        $from_row = pg_fetch_assoc($get_from_result);
        $from = $from_row['station_code'];
        //echo $from;
    } else {
        die("Error fetching station code: " . pg_last_error($conn));
    }

    $get_to = "SELECT station_code FROM stations WHERE station_name = $1";
    $get_to_result = pg_query_params($conn, $get_to, array($to_station));
    if ($get_to_result) {
        $to_row = pg_fetch_assoc($get_to_result);
        $to = $to_row['station_code'];
        //echo $to;
    } else {
        die("Error fetching station code: " . pg_last_error($conn));
    }

    $check_query = "SELECT route_code FROM routes WHERE start_station = $1 AND end_station = $2";
    $check_result = pg_query_params($conn, $check_query, array($from, $to));

    if ($check_result && pg_num_rows($check_result) > 0) {
        $row_check = pg_fetch_assoc($check_result);
        $route_code = $row_check['route_code'];
        echo '<script>window.alert("Route already Exists with Route Code = ' . $route_code . ' !!!"); window.location.href="ad_add_route.php";</script>';
    } else {
        $counter_query = "SELECT counter FROM route_code_generator ORDER BY r_id DESC LIMIT 1";
        $counter_result = pg_query($conn, $counter_query);

        if ($counter_result) {
            $row = pg_fetch_assoc($counter_result);
            $counter = $row['counter'];

            $newCounter = $counter + 1;
            $updateCounter = "INSERT INTO route_code_generator (counter) VALUES ($1)";
            $newResult = pg_query_params($conn, $updateCounter, array($newCounter));

            if ($newResult) {
                $route_code = 'RTE' . $counter;
                $route_add_query = "INSERT INTO routes (route_code, start_station, end_station, time_taken, distance, status) VALUES ($1, $2, $3, $4, $5, $6)";
                $route_add_params = array($route_code, $from, $to, $time_taken, $dist, $status);
                $route_add_execute = pg_query_params($conn, $route_add_query, $route_add_params);

                if ($route_add_execute) {
                    echo '<script>window.alert("Route has been added Successfully with Route Code = ' . $route_code . ' !!!"); window.location.href="ad_more_options.php";</script>';
                } else {
                    $rev_query = "DELETE FROM route_code_generator WHERE counter = $1";
                    $rev_execute = pg_query_params($conn, $rev_query, array($newCounter));
                    echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_add_route.php";</script>';
                    echo "Error: " . pg_last_error($conn);
                }
            } else {
                die("Error updating counter: " . pg_last_error($conn));
            }
        } else {
            die("Error fetching counter: " . pg_last_error($conn));
        }
    }
} else if ($do === 'REM') {
    $station_name = $_POST["station_name"] ?? '';
    $rem_query = "UPDATE stations SET status='In-active' WHERE station_name = $1";
    $rem_execute = pg_query_params($conn, $rem_query, array($station_name));
    if ($rem_execute) {
        echo '<script>window.alert("Station has been removed Successfully!!!"); window.location.href="ad_rem_station.php";</script>';
    } else {
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_rem_station.php";</script>';
    }
} else if ($do === 'EDIT') {
    $station_name = $_POST["station_name"] ?? '';
    $state = $_POST["state"] ?? '';
    $no_of_platforms = $_POST["no_of_platforms"] ?? '';
    $station_code = $_POST["station_code"] ?? '';

    $update_station = "UPDATE stations SET station_name = $1, state = $2, no_of_platform = $3 WHERE station_code = $4";
    $result = pg_query_params($conn, $update_station, array($station_name, $state, $no_of_platforms, $station_code));

    if ($result) {
        echo '<script>window.alert("Your Station is Successfully Updated !!!"); window.location.href="ad_edit_station.php";</script>';
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}else if ($do === 'ACT') {
    $route_code = $_POST["route_code"] ?? '';

    $start_query = "SELECT status FROM stations WHERE station_code IN (SELECT start_station FROM routes WHERE route_code = $1)";
    $start_execute = pg_query_params($conn, $start_query, array($route_code));
    if($start_execute){
        $start_status = pg_fetch_assoc($start_execute);
        if($start_status['status']  === 'Active'){
            $end_query = "SELECT status FROM stations WHERE station_code IN (SELECT end_station FROM routes WHERE route_code = $1)";
            $end_execute = pg_query_params($conn, $end_query, array($route_code));
            if($end_execute){
                $end_status = pg_fetch_assoc($end_execute);
                if($end_status['status']  === 'Active'){
                    $update_route = "UPDATE routes SET status = 'Active' WHERE route_code = $1";
                    $result = pg_query_params($conn, $update_route, array($route_code));
                    if ($result) {
                        echo '<script>window.alert("Your Route is Successfully Activated !!!"); window.location.href="ad_more_options.php";</script>';
                    } else {
                        echo "Error: " . pg_last_error($conn);
                    }
                }else {
                    echo '<script>window.alert("Your Route Can\'t be Activated as '.$to_station.' Station is Not In Service !!!"); window.location.href="ad_act_route.php";</script>';
                }
            } else {
                echo "Error: " . pg_last_error($conn);
            }
        }else {
            echo '<script>window.alert("Your Route Can\'t be Activated as '.$from_station.' Station is Not In Service !!!"); window.location.href="ad_act_route.php";</script>';
        }
    } else {
        echo "Error: " . pg_last_error($conn);
    }
    
}

pg_close($conn);
?>
