<?php
session_start();

if(isset($_SESSION['admin_username'])){
    $ad_username = $_SESSION['admin_username'];
    $train_no = $_POST['train_no'];
    $doj = $_POST['doj'];
    $coach_class = $_POST['coach_class'];
    if($coach_class === 'AC Chair Car'){
        $coach_no = 'A1';
    }else if($coach_class === '2S Sitting Car'){
        $coach_no = 'B1';
    }

}

    include '../process/!admin_username.php';

    include '../process/connect.php';

    $user = "SELECT tickets.ticket_no,tickets.user_type, seat_allocated.coach_no, seat_allocated.seat_no FROM tickets, seat_allocated WHERE tickets.ticket_no = seat_allocated.ticket_no AND tickets.status ='Confirmed' AND seat_allocated.doj = $1 AND seat_allocated.coach_no = $3 AND tickets.train_no = $2  ORDER BY tickets.ticket_no DESC";
    $query = pg_query_params($conn, $user, array($doj,$train_no,$coach_no));
    if (!$query) {
        die("Query failed: " . pg_last_error());
    }
    $count = pg_num_rows($query);

    $getName = "SELECT train_name, route_code from trains where train_no = $1";
    $getExe = pg_query_params($conn,$getName,array($train_no));
    if (!$getExe) {
        die("Query failed: " . pg_last_error());
    }
    $getRow = pg_fetch_assoc($getExe);
    $train_name = $getRow['train_name'];
    $route_code = $getRow['route_code'];

    $getFromTo = "SELECT start_station, end_station FROM routes WHERE route_code = $1";
    $getFromToExe = pg_query_params($conn,$getFromTo,array($route_code));
    if (!$getFromToExe) {
        die("Query failed: " . pg_last_error());
    }
    $getFromToRow = pg_fetch_assoc($getFromToExe);
    $start_station = $getFromToRow['start_station'];
    $end_station = $getFromToRow['end_station'];

    $getStationName = "SELECT station_name FROM stations WHERE station_code = $1";
    $getFromExe = pg_query_params($conn,$getStationName,array($start_station));
    if (!$getFromExe) {
        die("Query failed: " . pg_last_error());
    }
    $getFromRow = pg_fetch_assoc($getFromExe);
    $from = $getFromRow['station_name'];

    $getToExe = pg_query_params($conn,$getStationName,array($end_station));
    if (!$getToExe) {
        die("Query failed: " . pg_last_error());
    }
    $getToRow = pg_fetch_assoc($getToExe);
    $to= $getToRow['station_name'];



    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/list_tickets.css">
    <title>VIEW CHART</title>
    <script src="../script/<?php echo $type; ?>_logout.js" defer></script>
</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col1">
                
                        <div class="nav">
                            <ul>
                                <li><a href="../admin/ad_pass_options.php">PASSENGERS</a></li>
                                <li><a href="../admin/ad_ta_options.php">TRAVEL AGENTS</a></li>
                                <li><a href="../admin/ad_emp_options.php">EMPLOYEES</a></li>
                                <li><a href="../admin/ad_train_options.php">TRAINS</a></li>
                                <li><a href="../admin/ad_station_options.php">STATIONS</a></li>
                                <li><a href="../admin/ad_view_options.php" >VIEW USERS</a></li>
                                <li><a href="../admin/ad_more_options.php" id="ta_selected" >MORE OPTIONS</a></li>
                                <li><a href="#" onclick="logout()">LOG OUT</a></li>
                            </ul>
                        </div>
            </div>
            
            <div class="colb">
                <br>
                <h2 style="text-align:center;width:100%">CHART FOR TRAIN NO : <?php echo $_POST['train_no'];?> AND DOJ : <?php echo $_POST['doj'];?> </h2>
                <h2 style="text-align:center;width:100%">TRAIN NAME : <?php echo $train_name;?></h2>
                <h2 style="text-align:center;width:100%">From  <?php echo $from;?> Station To <?php echo $to;?> Station</h2>


            <table style="width:100%">
                <tr>
                    <th style="width:190px">Ticket No.</th>
                    <th style="width:190px">Name</th>
                    <th style="width:190px;text-align:center">Age</th>
                    <th style="width:190px">Gender</th>
                    <th style="width:190px">Seat No.</th>
                </tr>
                           
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){
                            $ticket_no = htmlspecialchars($row['ticket_no']);
                            $seat_no = htmlspecialchars($row['seat_no']);
                            $coach_no = htmlspecialchars($row['coach_no']);
                            $user_type = htmlspecialchars($row['user_type']);
                            if($user_type === "passenger"){
                                $userType = 'tickets_pass';
                            }else if($user_type === "employee"){
                                $userType = 'tickets_emp';
                            }else if($user_type === "travel_agent"){
                                $userType = 'tickets_ta';
                            }
                            $user_info = "SELECT user_name, user_age, user_gender FROM $userType WHERE ticket_no = $1";
                            $query_info = pg_query_params($conn, $user_info, array($ticket_no));
                            if (!$query_info) {
                                die("Query failed: " . pg_last_error());
                            }else{
                                $row_info = pg_fetch_assoc($query_info);
                                $user_name = htmlspecialchars($row_info['user_name']);
                                $user_age = htmlspecialchars($row_info['user_age']);
                                $user_gender = htmlspecialchars($row_info['user_gender']);
                            }
                            

                            ?>
                            <tr>
                            <td><?php echo htmlspecialchars($ticket_no); ?></td>
                            <td><?php echo htmlspecialchars($user_name); ?></td>
                            <td style="width:190px;text-align:center"><?php echo htmlspecialchars($user_age); ?></td>
                            <td><?php echo htmlspecialchars($user_gender); ?></td>
                            <td><?php echo htmlspecialchars($coach_no); ?> / <?php echo htmlspecialchars($seat_no); ?></td>

                        </tr>
                            
                        <?php
                        }
                    }
                ?>
                </table>
                <?php
                    if ($count == 0){
                        ?>

                        <p class="no-user" style="text-align:center;width:100%">
                            No Booking Done !!!
                    </p>
                        <?php
                    }
                ?>
                <br><br>
                <div class="signup1" style="text-align:center;">
            <button onclick="location.href='ad_more_options.php'" type="button" id="signup1">Close</button><br>
            </div>
            </div>
        </footer>
    </div>
</body>
</html>
<?php
pg_close($conn);
?>