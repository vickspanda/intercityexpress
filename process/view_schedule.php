<?php

include '../process/connect.php';

if(isset($_POST["train_no"]))
{
    $train_no = $_POST["train_no"];
}

function get_train_data($conn, $train_no, $field) {
    $query = "SELECT $field FROM trains WHERE train_no = $1";
    $result = pg_query_params($conn, $query, array($train_no));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("Train Not Found !!!"); window.location.href="ad_view_trains.php";</script>';
    }
}

function get_station_name($conn, $station, $route_code){
    $query = "SELECT station_name FROM stations where station_code IN (SELECT $station from routes WHERE route_code = $1)";
    $result = pg_query_params($conn, $query, array($route_code));
    if($result && pg_num_rows($result) > 0){
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("Start Station Not Found !!!"); window.location.href="ad_view_trains.php";</script>';
    }
}

function get_dep_data($conn, $train_no, $field){
    $query = "SELECT $field FROM train_schedule WHERE train_no = $1";
    $result = pg_query_params($conn, $query, array($train_no));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("Train Not Found !!!"); window.location.href="ad_view_trains.php";</script>';
    }
}

$flag = FALSE;
$train_name = get_train_data($conn, $train_no, 'train_name');
$train_status = get_train_data($conn, $train_no, 'status');
$route_code = get_train_data($conn, $train_no, 'route_code');
$start_station = get_station_name($conn, 'start_station', $route_code);
$end_station = get_station_name($conn, 'end_station', $route_code);
$ss_fare = get_train_data($conn, $train_no, 'ss_fare');
$ac_fare = get_train_data($conn, $train_no, 'ac_fare');

$dep = get_dep_data($conn, $train_no, 'dep');
$mon = get_dep_data($conn, $train_no, 'mon');
$tue = get_dep_data($conn, $train_no, 'tue');
$wed = get_dep_data($conn, $train_no, 'wed');
$thu = get_dep_data($conn, $train_no, 'thu');
$fri = get_dep_data($conn, $train_no, 'fri');
$sat = get_dep_data($conn, $train_no, 'sat');
$sun = get_dep_data($conn, $train_no, 'sun');
if ($sun == 'TRUE'){
    if($flag == TRUE){
        $run_on = $run_on .', ';
    }
    $run_on = $run_on .'Sun';
    $flag = TRUE;
}
if ($mon == 'TRUE'){
    if($flag == TRUE){
        $run_on = $run_on .', ';
    }
    $run_on = $run_on .'Mon';
    $flag = TRUE;
}
if ($tue == 'TRUE'){
    if($flag == TRUE){
        $run_on = $run_on .', ';
    }
    $run_on = $run_on . 'Tues';
    $flag = TRUE;
}
if ($wed == 'TRUE'){
    if($flag == TRUE){
        $run_on = $run_on .', ';
    }
    $run_on = $run_on .'Wed';
    $flag = TRUE;
}
if ($thu == 'TRUE'){
    if($flag == TRUE){
        $run_on = $run_on .', ';
    }
    $run_on = $run_on .'Thurs';
    $flag = TRUE;
}
if ($fri == 'TRUE'){
    if($flag == TRUE){
        $run_on = $run_on .', ';
    }
    $run_on = $run_on .'Fri';
    $flag = TRUE;
}
if ($sat == 'TRUE'){
    if($flag == TRUE){
        $run_on = $run_on .', ';
    }
    $run_on = $run_on .'Sat';
    $flag = TRUE;
}

$run_on = $run_on. ' only';
if($mon == 'TRUE' && $tue == 'TRUE' && $wed == 'TRUE' && $thu == 'TRUE' && $fri == 'TRUE' && $sat == 'TRUE' && $sun == 'TRUE'){
    $run_on = 'Every Day';
}


pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/viewSchedule.css">

    <title>View Schedule</title>
    <script src="../script/admin_logout.js" defer></script>

</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account">

    <h1 style="text-align:center">View Schedule</h1>
        <footer>

            <table>

                <tr>
                    <td>Train Number</td>
                    <td><?php echo htmlspecialchars($train_no); ?></td>
                </tr>
                <tr>
                    <td>Train Name</td>
                    <td><?php echo htmlspecialchars($train_name); ?></td>
                </tr>
                <tr>
                    <td>Route Name</td>
                    <td><?php echo htmlspecialchars($start_station); ?> to <?php echo htmlspecialchars($end_station); ?></td>
                </tr>
                <tr>
                    <td>Departs At</td>
                    <td><?php echo htmlspecialchars($dep); ?></td>
                </tr>
                <tr>
                    <td>Second Sitting Fare</td>
                    <td>Rs. <?php echo htmlspecialchars($ss_fare); ?></td>
                </tr>
                <tr>
                    <td>AC Sitting Fare</td>
                    <td>Rs. <?php echo htmlspecialchars($ac_fare); ?></td>
                </tr>
                <tr>
                    <td>Train Status</td>
                    <td><?php echo htmlspecialchars($train_status)?></td>
                </tr>
                <tr>
                    <td>Runs On</td>
                    <td><?php echo htmlspecialchars($run_on)?></td>
                </tr>
            </table>
        </footer>
        <div class="signup">
            <br>
            <form action="../process/schedule.php" method="POST">
                                <input name="from_station" value="<?php echo $start_station ?>" hidden>
                                <input name="to_station" value="<?php echo $end_station ?>" hidden>
                                <button type="submit" id="signup1">BACK</button>
                            </form>
            <br><br><br>
        </div>
    </div>
</body>
</html>
