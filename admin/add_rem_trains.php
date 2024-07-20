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


// Initialize variables
$mon = 'FALSE';
$tue = 'FALSE';
$wed = 'FALSE';
$thu = 'FALSE';
$fri = 'FALSE';
$sat = 'FALSE';
$sun = 'FALSE';

$train_name = $_POST["train_name"] ?? '';
$train_no = $_POST["train_no"] ?? '';
$route_code = $_POST["route_code"] ?? '';
$do = $_POST["do"] ?? '';
$status = 'Active';
$dep = $_POST["dep"] ?? '';
$ss_fare = $_POST["SS_fare"] ?? '';
$ac_fare = $_POST["AC_fare"] ?? '';


if (isset($_POST["mon"])) {
    $mon = $_POST["mon"];
}
if (isset($_POST["tue"])) {
    $tue = $_POST["tue"];
}
if (isset($_POST["wed"])) {
    $wed = $_POST["wed"];
}
if (isset($_POST["thu"])) {
    $thu = $_POST["thu"];
}
if (isset($_POST["fri"])) {
    $fri = $_POST["fri"];
}
if (isset($_POST["sat"])) {
    $sat = $_POST["sat"];
}
if (isset($_POST["sun"])) {
    $sun = $_POST["sun"];
}

if ($do === 'ADD') {
    // Begin transaction
    pg_query($conn, "BEGIN");

    $train_add_query = "INSERT INTO trains (train_no, train_name, route_code, status, ss_fare, ac_fare) VALUES ($1, $2, $3, $4, $5, $6);";
    $train_add_params = array($train_no, $train_name, $route_code, $status, $ss_fare, $ac_fare);
    $train_add_execute = pg_query_params($conn, $train_add_query, $train_add_params);

    if ($train_add_execute) {
        $sch_add_query = "INSERT INTO train_schedule (route_code, train_no, mon, tue, wed, thu, fri, sat, sun, dep) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10);";
        $sch_add_params = array($route_code, $train_no, $mon, $tue, $wed, $thu, $fri, $sat, $sun, $dep);
        $sch_add_execute = pg_query_params($conn, $sch_add_query, $sch_add_params);

        if ($sch_add_execute) {
            // Commit transaction
            pg_query($conn, "COMMIT");
            echo '<script>window.alert("Train has been added Successfully with Train No = ' . $train_no . '!!!"); window.location.href="ad_train_options.php";</script>';
        } else {
            // Rollback transaction
            pg_query($conn, "ROLLBACK");
            echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_add_trains.php";</script>';
            echo "Error: " . pg_last_error($conn);
        }
    } else {
        // Rollback transaction
        pg_query($conn, "ROLLBACK");
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_add_trains.php";</script>';
        echo "Error: " . pg_last_error($conn);
    }
}

else if ($do === 'Update') {
    pg_query($conn, "BEGIN");
    $train_update_query = "UPDATE trains SET train_name = $1, ss_fare = $2, ac_fare = $3 WHERE train_no = $4";
    $train_update_execute = pg_query_params($conn, $train_update_query, array($train_name, $ss_fare, $ac_fare, $train_no));

    if($train_update_execute){
        $schedule_update_query = "UPDATE train_schedule SET mon = $1, tue = $2, wed = $3, thu = $4, fri = $5, sat = $6, sun = $7, dep = $8 WHERE train_no = $9";
        $schedule_update_execute = pg_query_params($conn, $schedule_update_query, array($mon,$tue,$wed,$thu,$fri,$sat,$sun,$dep,$train_no));
        if($schedule_update_execute){
            pg_query($conn, "COMMIT");
            echo '<script>window.alert("Train has been Updated Successfully !!!"); window.location.href="ad_train_options.php";</script>';
        }
        else{
            pg_query($conn, "ROLLBACK");
            echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_train_update.php";</script>';
            echo "Error: " . pg_last_error($conn);
        }
    } else{
        pg_query($conn, "ROLLBACK");
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_train_update.php";</script>';
        echo "Error: " . pg_last_error($conn);
    }
}

else if ($do === 'Block') {
    $train_no = $_POST["train"];

    pg_query($conn, "BEGIN");

    $check_query = "SELECT status FROM trains WHERE train_no = $1";
    $check_execute = pg_query_params($conn, $check_query, array($train_no));
    if($check_execute){
        $check_row = pg_fetch_assoc($check_execute);
        if($check_row['status'] === 'Active')
        {
            $train_update_query = "UPDATE trains SET status = 'In-active' WHERE train_no = $1";
            $train_update_execute = pg_query_params($conn, $train_update_query, array($train_no));

            if($train_update_execute){
                pg_query($conn, "COMMIT");
                echo '<script>window.alert("Train has been Removed Successfully !!!"); window.location.href="ad_train_options.php";</script>';
            } else{
                pg_query($conn, "ROLLBACK");
                echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_rem_train.php";</script>';
                echo "Error: " . pg_last_error($conn);
            }
        }
        else {
            // Rollback transaction
            pg_query($conn, "ROLLBACK");
            echo '<script>window.alert("Train is Already Not In Service !!!"); window.location.href="ad_rem_train.php";</script>';
        }
    }
} else if ($do === 'ACT') {
    $train_no = $_POST["train"] ?? '';

    pg_query($conn, "BEGIN");

    $check_query = "SELECT status FROM trains WHERE train_no = $1";
    $check_execute = pg_query_params($conn, $check_query, array($train_no));
    if ($check_execute) {
        $check_row = pg_fetch_assoc($check_execute);
        if ($check_row['status'] === 'In-active') {
            $check_route = "SELECT status FROM routes WHERE route_code IN (SELECT route_code FROM trains WHERE train_no = $1)";
            $check_route_execute = pg_query_params($conn, $check_route, array($train_no));
            if ($check_route_execute && pg_num_rows($check_route_execute) > 0) {
                $route_row = pg_fetch_assoc($check_route_execute);
                if ($route_row['status'] === 'Active') {
                    $train_update_query = "UPDATE trains SET status = 'Active' WHERE train_no = $1";
                    $train_update_execute = pg_query_params($conn, $train_update_query, array($train_no));

                    if ($train_update_execute) {
                        pg_query($conn, "COMMIT");
                        echo '<script>window.alert("Train has been Activated Successfully !!!"); window.location.href="ad_train_options.php";</script>';
                    } else {
                        pg_query($conn, "ROLLBACK");
                        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_act_train.php";</script>';
                        echo "Error: " . pg_last_error($conn);
                    }
                } else {
                    pg_query($conn, "ROLLBACK");
                    echo '<script>window.alert("Train Can\'t be Activated as it\'s Route is Not In Service !!!"); window.location.href="ad_act_train.php";</script>';
                }
            } else {
                pg_query($conn, "ROLLBACK");
                echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_act_train.php";</script>';
                echo "Error: " . pg_last_error($conn);
            }
        } else {
            pg_query($conn, "ROLLBACK");
            echo '<script>window.alert("Train is Already In Service !!!"); window.location.href="ad_act_train.php";</script>';
        }
    } else {
        pg_query($conn, "ROLLBACK");
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="ad_act_train.php";</script>';
        echo "Error: " . pg_last_error($conn);
    }
}



// Close the connection
pg_close($conn);
?>
