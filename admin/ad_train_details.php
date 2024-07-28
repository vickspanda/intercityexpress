<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';

if(isset($_GET["train_no"]))
{
    $train_no = $_GET["train_no"];
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
    <link rel="stylesheet" href="../design/pa_acc.css">
    <link rel="stylesheet" href="../design/pass_ppv.css">

    <title>View Train Details</title>
    <script src="../script/admin_logout.js" defer></script>

</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
        <div class="col1">
                <div class="nav">
                    <ul>
                        <li><a href="ad_pass_options.php">PASSENGERS</a></li>
                        <li><a href="ad_ta_options.php">TRAVEL AGENTS</a></li>
                        <li><a href="ad_emp_options.php">EMPLOYEES</a></li>
                        <li><a href="ad_train_options.php">TRAINS</a></li>
                        <li><a href="ad_station_options.php">STATIONS</a></li>
                        <li><a href="ad_view_options.php" >VIEW USERS</a></li>
                        <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col2_ppv">
                Train Number <br><br>
                Train Name <br><br>
                Route Name <br><br>
                Departs At <br><br>
                Second Sitting Fare <br><br>
                AC Sitting Fare <br><br>
                Train Status <br><br>
                Runs On <br>
                
            </div>
            <div class="col3_ppv">
                <?php echo htmlspecialchars($train_no); ?><br><br>
                <?php echo htmlspecialchars($train_name); ?><br><br>
                <?php echo htmlspecialchars($start_station); ?> to <?php echo htmlspecialchars($end_station); ?><br><br>
                <?php echo htmlspecialchars($dep); ?><br><br>
                Rs. <?php echo htmlspecialchars($ss_fare); ?><br><br>
                Rs. <?php echo htmlspecialchars($ac_fare); ?><br><br>
                <?php echo htmlspecialchars($train_status)?> <br><br>
                <?php echo htmlspecialchars($run_on)?> <br>
                
            </div>
        </footer>
        <div class="signup">
            <br>
            <button onclick="location.href='ad_view_trains.php?status=<?php echo $train_status;?>'" type="button" id="signup1">Back</button>
            <br><br><br>
        </div>
    </div>
</body>
</html>
