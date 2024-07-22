<?php
include 'connect.php';

$from_station = $_POST['from_station'] ?? '';
$to_station = $_POST['to_station'] ?? '';
$doj = $_POST['date_of_journey'] ?? '';
$seat_type = $_POST['coach_class'] ?? '';
$fare = '';
$total_seats = 20;
$day_doj = new DateTime($doj);
$day_of_doj = $day_doj->format('l');
if($day_of_doj === 'Monday'){
    $day = 'mon';
}
if($day_of_doj === 'Tuesday'){
    $day = 'tue';
}
if($day_of_doj === 'Wednesday'){
    $day = 'wed';
}
if($day_of_doj === 'Thursday'){
    $day = 'thu';
}
if($day_of_doj === 'Friday'){
    $day = 'fri';
}
if($day_of_doj === 'Saturday'){
    $day = 'sat';
}
if($day_of_doj === 'Sunday'){
    $day = 'sun';
}

if ($seat_type === '2S Sitting Car') {
    $fare = 'ss_fare';
    $coach_no = 'D1';
} elseif ($seat_type === 'AC Chair Car') {
    $fare = 'ac_fare';
    $coach_no = 'A1';
}

if(!$from_station || !$to_station){
    echo '<script>window.location.href="../index.html";</script>';
    exit();
}

$stnCode_query = "SELECT station_code FROM stations WHERE station_name = $1";
$from_stnCode = pg_query_params($conn, $stnCode_query, array($from_station));
$startStn = '';
$endStn = '';
$count = 0;

if ($from_stnCode && pg_num_rows($from_stnCode) > 0) {
    $from = pg_fetch_assoc($from_stnCode);
    $startStn = $from['station_code'];

    $to_stnCode = pg_query_params($conn, $stnCode_query, array($to_station));
    if ($to_stnCode && pg_num_rows($to_stnCode) > 0) {
        $to = pg_fetch_assoc($to_stnCode);
        $endStn = $to['station_code'];

        $_SESSION['endStn'] = $endStn;
        $_SESSION['startStn'] = $startStn;

        $getroute = "SELECT route_code, time_taken FROM routes WHERE start_station = $1 and end_station = $2";
        $route_execute = pg_query_params($conn, $getroute, array($startStn, $endStn));
        if ($route_execute && pg_num_rows($route_execute) > 0) {
            $result = pg_fetch_assoc($route_execute);
            $route_code = $result['route_code'];
            $time_taken = $result['time_taken'];
            $xyz = 'Active';
            $abc = 'TRUE';

            $get_train = "SELECT trains.train_no, trains.train_name, $fare FROM trains, train_schedule WHERE trains.route_code = $1 AND trains.status=$2 AND train_schedule.$day=$3 AND trains.train_no=train_schedule.train_no ORDER BY train_no DESC LIMIT 2";
            $train_execute = pg_query_params($conn, $get_train, array($route_code,$xyz,$abc));
            $count = pg_num_rows($train_execute);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/train_search.css">
    <title>Search Results</title>
</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
                <br>
                <h2><?php echo htmlspecialchars($from_station); ?> to <?php echo htmlspecialchars($to_station); ?></h2>
                <div class="details">
                <table style="width:90%">
                    <tr>
                        <th>Train No.</th>
                        <th style="width:300px">Train Name</th>
                        <th >Fare</th>
                        <th style="text-align:center; width:200px">Action</th>
                    </tr>
                    <?php 
                    if ($count > 0) {
                        while ($train_info = pg_fetch_assoc($train_execute)) {
                            $train_no = htmlspecialchars($train_info['train_no']);
                            $train_name = htmlspecialchars($train_info['train_name']);
                            $train_fare = htmlspecialchars($train_info[$fare]);
                            $get_train_info = "SELECT * FROM train_schedule WHERE train_no = $1";
                            $get_execute = pg_query_params($conn, $get_train_info, array($train_no));
                            if($get_execute){
                                $train_schedule = pg_fetch_assoc($get_execute);
                                $dep = $train_schedule['dep'];
                                $dep_time = $doj .' '. $dep;
                                
                                $add_time_query = "SELECT $1::timestamp + $2::interval AS arr";
                                $add_time_result = pg_query_params($conn, $add_time_query, array($dep_time, $time_taken));
                                $ticket_status = 'Confirmed';
                                $get_booked_info = "SELECT count(*) from tickets, seat_allocated WHERE tickets.ticket_no = seat_allocated.ticket_no AND seat_allocated.doj = $1 and tickets.train_no = $2 and seat_allocated.coach_no = $3 AND tickets.status = $4";
                                $get_booked_execute = pg_query_params($conn, $get_booked_info,array($doj,$train_no,$coach_no,$ticket_status));
                                if($get_booked_execute){
                                    $get_count = pg_fetch_assoc($get_booked_execute);
                                    $booked_seats_count = $get_count['count'];
                                    $get_total_info = "SELECT count(*) from seats";
                                    $get_total_execute = pg_query($conn, $get_total_info);
                                    if($get_total_execute){
                                        $get_total_count = pg_fetch_assoc($get_total_execute);
                                        $total_seats = $get_total_count['count'];
                                        $avl_seats = $total_seats - $booked_seats_count;
                                    }else{
                                        echo 'Error';
                                    }
                                }else{
                                    echo 'Error';
                                }
                                if ($add_time_result && pg_num_rows($add_time_result) > 0) {
                                    $new_time_row = pg_fetch_assoc($add_time_result);
                                    $arr_time = $new_time_row['arr'];

                                } else {
                                    echo "Error calculating new time: " . pg_last_error($conn);
                                }
                            } else {
                                $dep_time = 'N/A';
                                $arr_time = 'N/A';
                            }
                        
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($train_no); ?><br></td>
                                <td><?php echo htmlspecialchars($train_name); ?></td>
                                <td><?php echo 'Rs. ' . htmlspecialchars($train_fare); ?></td>
                                <form action="book_login.php" method="POST">
                                    <input name="train_no" value="<?php echo $train_no?>" hidden>
                                    <input name="train_fare" value="<?php echo $train_fare?>" hidden>
                                    <input name="doj" value="<?php echo $doj?>" hidden>
                                    <input name="dep_time" value="<?php echo $dep_time?>" hidden>
                                    <input name="arr_time" value="<?php echo $arr_time?>" hidden>
                                    <input name="coach_no" value="<?php echo $coach_no?>" hidden>
                                    <input name="endStn" value="<?php echo $endStn?>" hidden>
                                    <input name="startStn" value="<?php echo $startStn?>" hidden>
                                    <input name="total_seats" value="<?php echo $total_seats?>" hidden>


                                

                                    <?php
                                        if($avl_seats == 0){
                                            ?>

                                <td style="text-align:center"><?php echo "Not Applicable"; ?></td>

                                            <?php
                                        }else{
                                            ?>
                                <td style="text-align:center"><?php echo "<button type=\"submit\" id=\"unblock\">BOOK TICKET</button>"; ?></td>
                                            
                                            <?php
                                        }
                                    ?>
                                </form>
                            </tr>
                            <tr>
                                <td>Starts on:<br></td>
                                <td><?php echo htmlspecialchars($dep_time); ?></td>
                                <td>Ends on:</td>
                                <td style="text-align:center"><?php echo htmlspecialchars($arr_time); ?></td>
                            </tr>
                            <tr>
                                <td>Coach Class:</td>
                                <td><?php echo htmlspecialchars($seat_type);?></td>
                                <td>Seats Available:</td>
                                <td style="text-align:center"><?php echo htmlspecialchars($avl_seats);?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
                </div>
                <?php 
                if ($count == 0) {
                ?>
                    <p class="no-user">
                        No Train(s) Found for This Route!!!
                    </p>
                <?php
                }
                ?>
        <button onclick="location.href='../index.html'" type="button" id="signup1">Back</button><br><br>
    </div>
</body>
</html>
<?php
pg_close($conn);

?>
