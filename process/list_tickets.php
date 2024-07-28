<?php
session_start();
include '../process/connect.php';

if(isset($_SESSION['pass_username'])){
    $username = $_SESSION['pass_username'];
    $userType = 'tickets_pass';
    $dbtable = 'passenger';
    $type = 'pass';
    $title = $_SESSION['title'];
    $getUserStatus = "SELECT status FROM $dbtable WHERE username = $1";
$getStatusExe = pg_query_params($conn, $getUserStatus, array($username));
if($getStatusExe){
    $getStatusRow = pg_fetch_assoc($getStatusExe);
    $status = $getStatusRow['status'];
    if($status === 'Blocked'){
        echo '<script>window.location.href="../process/block_alert.php";</script>';
    }
}
}

if(isset($_SESSION['emp_username'])){
    $username = $_SESSION['emp_username'];
    $userType = 'tickets_emp';

    $dbtable = 'employee';
    $type = 'emp';
$title = $_SESSION['title'];
$getUserStatus = "SELECT status FROM $dbtable WHERE username = $1";
$getStatusExe = pg_query_params($conn, $getUserStatus, array($username));
if($getStatusExe){
    $getStatusRow = pg_fetch_assoc($getStatusExe);
    $status = $getStatusRow['status'];
    if($status === 'Blocked'){
        echo '<script>window.location.href="../process/block_alert.php";</script>';
    }
}


}
if(isset($_SESSION['admin_username'])){
    $admin_username = $_SESSION['admin_username'];
    $count = 5;
    if(isset($_SESSION['userType'])){
        $userType = $_SESSION['userType'];
    }
    if(isset($_POST['userType'])){
        $userType = $_POST['userType'];
    }
    if($userType === 'employee'){
        $user_ticket = 'tickets_emp';
        $count = 5;
    }
    if($userType === 'passenger'){
        $user_ticket = 'tickets_pass';
    }
    if($userType === 'travel_agent'){
        $user_ticket = 'tickets_ta';
    }
    if(isset($_POST['username'])){
        $user_id = $_POST['username'];
    }
    $dbtable = 'admin';
    $type = 'admin';
}

if(isset($_SESSION['ta_username'])){
    $username = $_SESSION['ta_username'];
    $userType = 'tickets_ta';
    $dbtable = 'travel_agent';
    $type = 'ta';
$title = $_SESSION['title'];

$getUserStatus = "SELECT status FROM $dbtable WHERE username = $1";
$getStatusExe = pg_query_params($conn, $getUserStatus, array($username));
if($getStatusExe){
    $getStatusRow = pg_fetch_assoc($getStatusExe);
    $status = $getStatusRow['status'];
    if($status === 'Blocked'){
        echo '<script>window.location.href="../process/block_alert.php";</script>';
    }
}

}
if(!$username && !$admin_username){
    echo '<script>window.location.href="../index.html";</script>';
}


$today_date = date("Y-m-d");

if(!$admin_username){
    if($title === 'UPCOMING' || $title === 'CANCEL' || $title === 'DOWNLOAD'){

        $user = "SELECT tickets.ticket_no, tickets.board_stn, tickets.drop_stn, $userType.user_name, $userType.user_age, tickets.status, seat_allocated.doj FROM $userType, tickets, seat_allocated WHERE tickets.ticket_no = $userType.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND $userType.username = $1 AND tickets.status ='Confirmed' AND seat_allocated.doj >= $2 ORDER BY tickets.ticket_no DESC LIMIT 5";
        $query = pg_query_params($conn, $user, array($username,$today_date));
        if (!$query) {
            die("Query failed: " . pg_last_error());
        }
    
    }
    
    else{
        $user = "SELECT tickets.ticket_no, tickets.board_stn, tickets.drop_stn, $userType.user_name, $userType.user_age, tickets.status, seat_allocated.doj FROM $userType, tickets, seat_allocated WHERE tickets.ticket_no = $userType.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND $userType.username = $1 AND tickets.ticket_no NOT IN (SELECT tickets.ticket_no FROM $userType, tickets, seat_allocated WHERE tickets.ticket_no = $userType.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND $userType.username = $1 AND tickets.status ='Confirmed' AND seat_allocated.doj >= $2) ORDER BY tickets.ticket_no DESC LIMIT 5";
        $query = pg_query_params($conn, $user, array($username,$today_date));
        if (!$query) {
            die("Query failed: " . pg_last_error());
        }
    }
}else{
    if(isset($_POST['username'])){
        $user = "SELECT tickets.ticket_no, tickets.board_stn, tickets.drop_stn, $user_ticket.user_name, $user_ticket.user_age, tickets.status, seat_allocated.doj FROM $user_ticket, tickets, seat_allocated WHERE tickets.ticket_no = $user_ticket.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND tickets.user_type = $1 AND $user_ticket.username = $2 ORDER BY tickets.ticket_no DESC LIMIT $count";
        $query = pg_query_params($conn, $user, array($userType,$user_id));
        if (!$query) {
            die("Query failed: " . pg_last_error());
        }
    }else{
        $user = "SELECT tickets.ticket_no, tickets.board_stn, tickets.drop_stn, $user_ticket.user_name, $user_ticket.user_age, tickets.status, seat_allocated.doj FROM $user_ticket, tickets, seat_allocated WHERE tickets.ticket_no = $user_ticket.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND tickets.user_type = $1 ORDER BY tickets.ticket_no DESC LIMIT $count";
        $query = pg_query_params($conn, $user, array($userType));
        if (!$query) {
            die("Query failed: " . pg_last_error());
        }
    }
}
$count = pg_num_rows($query);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/list_tickets.css">
    <title><?php echo $title.' ';?>TRIP</title>
    <script src="../script/<?php echo $type; ?>_logout.js" defer></script>
    <?php 
        if($title === 'CANCEL'){
            ?>
    <script src="../script/cancel.js" defer></script>
            
            <?php
        }
    ?>


</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col1">
                <?php
                    if($dbtable === 'passenger'){
                ?>
                
                <div class="nav">
                    <ul>
                    <li><a href="../process/get_task.php?title=UPCOMING">UPCOMING TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=PAST">PAST TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=CANCEL">CANCEL TRIP</a></li>
                        <li><a href="../process/get_task.php?title=DOWNLOAD">DOWNLOAD</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../passenger/passenger_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../process/feedback.php">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
                
                <?php

                    }else if($dbtable == 'employee'){

                        ?>
                
                <div class="nav">
                    <ul>
                        <li><a href="../employee/emp_view_options.php">UPCOMING TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=PAST">PAST TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=DOWNLOAD">DOWNLOAD</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../employee/emp_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../employee/emp_view_more.php">CONTACT DETAILS</a></li>
                        <li><a href="../process/feedback.php">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
                        
                        <?php

                    }else if($dbtable == 'travel_agent'){

                        ?>
                
                <div class="nav">
                    <ul>
                        <li><a href="../travel_agent/ta_view_options.php">UPCOMING TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=PAST">PAST TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=DOWNLOAD">DOWNLOAD</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../travel_agent/ta_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../travel_agent/ta_view_more.php">CONTACT DETAILS</a></li>
                        <li><a href="../process/feedback.php">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
                        
                        <?php

                    }else if($dbtable === 'admin'){

                        ?>
                
                        <div class="nav">
                            <ul>
                                <li><a href="../admin/ad_pass_options.php">PASSENGERS</a></li>
                                <li><a href="../admin/ad_ta_options.php">TRAVEL AGENTS</a></li>
                                <li><a href="../admin/ad_emp_options.php">EMPLOYEES</a></li>
                                <li><a href="../admin/ad_train_options.php">TRAINS</a></li>
                                <li><a href="../admin/ad_station_options.php">STATIONS</a></li>
                                <li><a href="../admin/ad_view_options.php" >VIEW USERS</a></li>
                                <li><a href="../admin/ad_more_options.php" >MORE OPTIONS</a></li>
                                <li><a href="#" onclick="logout()">LOG OUT</a></li>
                            </ul>
                        </div>
                        
                        <?php

                    }
                ?>
            </div>
            
            <div class="colb">
                <br>
                <h2 style="text-align:center;width:100%"><?php echo $title.' ';?>TRIPS</h2>
            <table style="width:100%">
                                
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){
                            $name = htmlspecialchars($row['user_name']);
                            $username = htmlspecialchars($row['username']);
                            $ticket_no = htmlspecialchars($row['ticket_no']);
                            $user_age = htmlspecialchars($row['user_age']);
                            $status = htmlspecialchars($row['status']);
                            $doj = htmlspecialchars($row['doj']);
                            $start = htmlspecialchars($row['board_stn']);
                            $end = htmlspecialchars($row['drop_stn']);

                            $get_station_name = "SELECT station_name from stations WHERE station_code = $1";
                            $get_start = pg_query_params($conn, $get_station_name, array($start));
                            $start_row = pg_fetch_assoc($get_start);
                            $from_station = $start_row['station_name'];
                        
                            $get_end = pg_query_params($conn, $get_station_name, array($end));
                            $end_row = pg_fetch_assoc($get_end);
                            $to_station = $end_row['station_name'];

                            ?>
                            
                                 <tr>
                                    <td><?php echo htmlspecialchars($ticket_no); ?></td>
                                <td style='width:220px' colspan="2"><?php echo htmlspecialchars($name); ?></td>
                                <td style='text-align:center'>Age :  <?php echo htmlspecialchars($user_age); ?> years</td>
                                <td >Date of Trip: </td>
                                <td style="text-align:center"><?php echo htmlspecialchars($doj); ?></td>
                                
                            </tr>  
                            <tr>
                            <td><?php if($from_station === 'Chattrapati Shivaji Maharaj Terminus' ){
                                ?>CSMT<?php
                            }else{
                                echo htmlspecialchars($from_station);
                            } ?></td>
                            <td style='width:50px' >To</td>

                            <td><?php if($to_station === 'Chattrapati Shivaji Maharaj Terminus' ){
                                ?>CSMT<?php
                            }else{
                                echo htmlspecialchars($to_station);
                            } ?></td>
                            <td>Status:</td>
                            <td><?php echo htmlspecialchars($status); ?></td>
                            <td rowspan="2">
                                <?php
                                    if($title === 'CANCEL'){
                                        ?>
                                        <form method="post" action="cancel_ticket.php" >
                                <input name="ticket_no" value="<?php echo $ticket_no; ?>" hidden>
                                <input id = "unblock" type="submit" value="CANCEL">
                                </form>
                            <?php
                                    }else if($title === 'DOWNLOAD'){
                                        ?>
                                        <form method="post" action="generatePDF.php" >
                                <input name="ticket_no" value="<?php echo $ticket_no; ?>" hidden>
                                <input name="userType" value="<?php echo $dbtable; ?>" hidden>
                                <input id = "unblock" type="submit" value="DOWNLOAD">
                                </form>
                            <?php
                                    }
                                    
                                    else{
                                        ?>
                                        <form method="POST" action="view_ticket.php">
                                <input name="ticket_no" value="<?php echo $ticket_no; ?>" hidden>
                                <?php
                                    if(!$admin_username){
                                        ?>
                                            <input name="userType" value="<?php echo $dbtable; ?>" hidden>
                                        <?php
                                    }else{
                                        if(isset($_POST['username'])){
                                            ?>
                                            <input name="more" value="TRUE" hidden>
                                            <?php
                                        }
                                        ?>
                                            <input name="userType" value="<?php echo $userType; ?>" hidden>
                                        <?php
                                    }
                                ?>
                                <input id = "unblock" type="submit" value="VIEW DETAILS">
                            </form>
                            <?php
                                    }
                                ?>

                            </td>
                            </tr>
                            <tr>
                            <td colspan="5"></td>
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
                            No Trip Found !!!
                        </div>
                        <?php
                    }
                ?>
            </div>
        </footer>
    </div>
</body>
</html>
<?php
pg_close($conn);
?>