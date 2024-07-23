<?php
session_start();
if(isset($_SESSION['pass_username'])){
    $username = $_SESSION['pass_username'];
}
if(isset($_SESSION['emp_username'])){
    $username = $_SESSION['emp_username'];
}
if(isset($_SESSION['admin_username'])){
    $admin_username = $_SESSION['admin_username'];
}
if(isset($_SESSION['ta_username'])){
    $username = $_SESSION['ta_username'];
}
if(!$username && !$admin_username){
    echo '<script>window.location.href="../index.html";</script>';
}

include '../process/connect.php';
$_POST['pass'] = 'passenger';


if(isset($_POST['pass'])){
    $db = $_POST['pass'];
    $userType = 'tickets_pass';
    $title = 'Passengers';
    $us_name = 'name';
    $id = 'pass_id';
    $next = 'pass_list';
    $redirect = 'ad_pass_profile.php';
}

if(isset($_POST['emp'])){
    $userType = 'tickets_emp';
    $title = 'Employees';
    $us_name = 'emp_name';
    $id = 'emp_uid';
    $next = 'emp_list';
    $redirect = 'ad_emp_profile.php';
}

if(isset($_POST['ta'])){
    $userType = 'tickets_ta';
    $title = 'Travel Agents';
    $us_name = 'ta_name';
    $id = 'ta_uid';
    $next = 'ta_list';
    $redirect = 'ad_ta_profile.php';
}


$user = "SELECT tickets.ticket_no, tickets.board_stn, tickets.drop_stn, $userType.user_name, $userType.user_age, tickets.status, seat_allocated.doj FROM $userType, tickets, seat_allocated WHERE tickets.ticket_no = $userType.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND $userType.username = $1 ORDER BY tickets.ticket_no DESC LIMIT 5";
$query = pg_query_params($conn, $user, array($username));
if (!$query) {
    die("Query failed: " . pg_last_error());
}

$count = pg_num_rows($query);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/list_tickets.css">
    <title><?php echo $title;?> List</title>
    <script src="../script/admin_logout.js" defer></script>


</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col1">
                <?php
                    if($db ==='passenger'){
                ?>
                
                <div class="nav">
                    <ul>
                        <li><a href="../process/list_tickets.php">UPCOMING TRIPS</a></li>
                        <li><a href="#">PAST TRIPS</a></li>
                        <li><a href="#">CANCEL TRIPS</a></li>
                        <li><a href="#">TRAINS</a></li>
                        <li><a href="#">STATIONS</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../passenger/passenger_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
                
                <?php

                    }else if($userType === 'employee'){

                        ?>
                
                        <div class="nav">
                            <ul>
                                <li><a href="ad_pass_options.php">PASSENGERS</a></li>
                                <li><a href="ad_ta_options.php">TRAVEL AGENTS</a></li>
                                <li><a href="ad_emp_options.php">EMPLOYEES</a></li>
                                <li><a href="ad_train_options.php">TRAINS</a></li>
                                <li><a href="ad_station_options.php">STATIONS</a></li>
                                <li><a href="ad_view_options.php"  id="ta_selected">VIEW USERS</a></li>
                                <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                                <li><a href="#" onclick="logout()">LOG OUT</a></li>
                            </ul>
                        </div>
                        
                        <?php

                    }else if($userType === 'travel_agent'){

                        ?>
                
                        <div class="nav">
                            <ul>
                                <li><a href="ad_pass_options.php">PASSENGERS</a></li>
                                <li><a href="ad_ta_options.php">TRAVEL AGENTS</a></li>
                                <li><a href="ad_emp_options.php">EMPLOYEES</a></li>
                                <li><a href="ad_train_options.php">TRAINS</a></li>
                                <li><a href="ad_station_options.php">STATIONS</a></li>
                                <li><a href="ad_view_options.php"  id="ta_selected">VIEW USERS</a></li>
                                <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                                <li><a href="#" onclick="logout()">LOG OUT</a></li>
                            </ul>
                        </div>
                        
                        <?php

                    }
                ?>
            </div>
            
            <div class="colb">
                <br>
                <h2 style="text-align:center">Tickets List</h2>
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
                            <td><?php echo htmlspecialchars($from_station); ?></td>
                            <td style='width:50px' >To</td>

                            <td><?php echo htmlspecialchars($to_station); ?></td>
                            <td>Status:</td>
                            <td><?php echo htmlspecialchars($status); ?></td>
                            <td rowspan="2"><form method="POST" action="view_ticket.php">
                                <input name="ticket_no" value="<?php echo $ticket_no; ?>" hidden>
                                <input name="userType" value="<?php echo $db; ?>" hidden>
                                <input id = "unblock" type="submit" value="VIEW DETAILS">
                            </form></td>
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

                        <p class="no-user">
                            No Active User Found !!!
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