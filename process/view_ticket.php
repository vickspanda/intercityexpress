<?php
    session_start();
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }
    if(isset($_SESSION['pass_username'])){
        $username = $_SESSION['pass_username'];
    }
    if(isset($_SESSION['emp_username'])){
        $username = $_SESSION['emp_username'];
    }
    if(isset($_SESSION['admin_username'])){
        $username = $_SESSION['admin_username'];
    }
    if(isset($_SESSION['ta_username'])){
        $username = $_SESSION['ta_username'];
    }
    if(!$username){
        echo '<script>window.location.href="../index.html";</script>';
    }
    include '../process/connect.php';
    if(isset($_SESSION['ticket_no'])){
        $ticket_no = $_SESSION['ticket_no'];
        echo '<script>window.alert("Your Ticket has been Booked Successfully!!!");</script>';

    }
    if(isset($_POST['ticket_no'])){
        $ticket_no = $_POST["ticket_no"] ?? '';
    }

    if(isset($_POST['userType'])){
        $userType = $_POST["userType"] ?? '';
    }
    if(isset($_SESSION['userType'])){
        $userType = $_SESSION["userType"] ?? '';
    }
    if($userType === 'passenger'){
        $user = 'passenger';
        $userTicket = 'tickets_pass';
    }
    if($userType === 'employee'){
        $user = 'emp';
        $userTicket = 'tickets_emp';
    }
    if($userType === 'travel_agent'){
        $user = 'ta';
        $userTicket = 'tickets_ta';
    }

    $get_ticket_info = "SELECT tickets.train_no, tickets.status, trains.train_name, tickets.board_stn, tickets.drop_stn, tickets.starts_on, tickets.ends_on, seat_allocated.coach_no, seat_allocated.seat_no, seats.seat_type, $userTicket.username, $userTicket.user_name, $userTicket.user_age, $userTicket.user_gender, payment.status as payment_status, payment.upi_used, payment.ticket_fare, payment.total_fare, payment.emp_conn, payment.ta_comm  FROM tickets, $userTicket, payment, seat_allocated, seats, trains WHERE tickets.ticket_no = $userTicket.ticket_no AND tickets.ticket_no = payment.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND tickets.train_no = trains.train_no AND seat_allocated.seat_no = seats.seat_no AND tickets.ticket_no = $1";
    $get_ticket_execute = pg_query_params($conn,$get_ticket_info,array($ticket_no));
    if(!$get_ticket_execute){
        echo "Error :". pg_last_error($conn);
    }else{
        $ticket_row = pg_fetch_assoc($get_ticket_execute);
        $train_no = $ticket_row['train_no'];
        $train_name = $ticket_row['train_name'];
        $status = $ticket_row['status'];
        $dep_time = $ticket_row['starts_on'];
        $arr_time = $ticket_row['ends_on'];
        $coach_no = $ticket_row['coach_no'];
        $seat_no = $ticket_row['seat_no'];
        $seat_type = $ticket_row['seat_type'];
        $username = $ticket_row['username'];
        $user_name = $ticket_row['user_name'];
        $user_age = $ticket_row['user_age'];
        $user_gender = $ticket_row['user_gender'];
        $payment_status = $ticket_row['payment_status'];
        $upi =$ticket_row['upi_used'];
        $total_fare = $ticket_row['total_fare'];
        $ticket_fare = $ticket_row['ticket_fare'];
        $ta_comm = $ticket_row['ta_comm'];
        $emp_conn = $ticket_row['emp_conn'];
        $start = $ticket_row['board_stn'];
        $end = $ticket_row['drop_stn'];
    }

    $get_station_name = "SELECT station_name from stations WHERE station_code = $1";
    $get_start = pg_query_params($conn, $get_station_name, array($start));
    $start_row = pg_fetch_assoc($get_start);
    $from_station = $start_row['station_name'];

    $get_end = pg_query_params($conn, $get_station_name, array($end));
    $end_row = pg_fetch_assoc($get_end);
    $to_station = $end_row['station_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/ticket_details.css">
    <title>Ticket Details</title>
</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
                <h1>Ticket Details</h1>
                <table style="width:90%">
                            <tr>
                                <td>Ticket No.:</td>
                                <td><?php echo htmlspecialchars($ticket_no); ?></td>
                                <td>Ticket Status:</td>
                                <td><?php echo htmlspecialchars($status); ?></td>
                            </tr>
                            <tr>
                                <td>Train No.:</td>
                                <td><?php echo htmlspecialchars($train_no); ?></td>
                                <td>Train Name:</td>
                                <td><?php echo htmlspecialchars($train_name); ?></td>
                            </tr>
                            <tr>
                                <td>Boarding Station:</td>
                                <td><?php echo htmlspecialchars($from_station); ?></td>
                                <td>Drop Station:</td>
                                <td><?php echo htmlspecialchars($to_station); ?></td>
                            </tr>
                            <tr>
                                <td>Starts on:</td>
                                <td><?php echo htmlspecialchars($dep_time); ?></td>
                                <td>Ends on:</td>
                                <td><?php echo htmlspecialchars($arr_time); ?></td>
                            </tr>
                            <tr>
                                <td>Coach Class:</td>
                                <td><?php if($coach_no==='D1')
                                {
                                    ?>
                                    2S Second Sitting
                                    <?php
                                }else if($coach_no==='A1'){
                                    ?>
                                    AC Chair Car
                                    <?php
                                }?></td>
                                <td>Seat No:</td>
                                <td><?php echo htmlspecialchars($coach_no);?> / <?php echo htmlspecialchars($seat_no);?></td>
                            </tr>
                            <tr>
                                <td>Username:</td>
                                <td><?php echo htmlspecialchars($username);?></td>
                                <td>Seat Type:</td>
                                <td><?php echo htmlspecialchars($seat_type);?></td>
                            </tr>
                            <tr>
                                <td>Traveler's Name</td>
                                <td><?php echo htmlspecialchars($user_name);?></td>
                                <td>Traveler's Age:</td>
                                <td><?php echo htmlspecialchars($user_age);?></td>
                            </tr>
                            <tr>
                                <td> Gender:</td>
                                <td><?php echo htmlspecialchars($user_gender);?></td>                                
                                <td>Payment Status:</td>
                                <td><?php echo htmlspecialchars($payment_status);?></td>
                            </tr>
                            <tr>
                                <td>UPI ID Used:</td>
                                <td><?php echo htmlspecialchars($upi);?></td>                                
                                <td>Ticket Fare:</td>
                                <td style="text-align:right">Rs. <?php echo htmlspecialchars($ticket_fare);?></td>
                            </tr>
                            <?php
                               if($userType === 'travel_agent'){
                            ?>
                            <tr>
                                <td></td>
                                <td></td>                                
                                <td>Agent's Commission:</td>
                                <td style="text-align:right">Rs. <?php echo htmlspecialchars($ta_comm);?></td>
                            </tr>
                            <?php
                            }
                            else if($userType === 'employee'){
                        ?>
                        <tr>
                            <td></td>
                            <td></td>                                
                            <td>Concession:</td>
                            <td style="text-align:right">-  Rs. <?php echo htmlspecialchars($emp_conn);?></td>
                        </tr>
                        <?php
                        }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>                                
                                <td>Total Fare:</td>
                                <td style="text-align:right">Rs. <?php echo htmlspecialchars($total_fare);?></td>
                            </tr>
                </table>
                <br>
        <button onclick="location.href='../<?php echo $userType?>/<?php echo $user;?>_dashboard.php'" type="button" id="signup1">Close</button>
        <br><br>
    </div>
    
</body>
</html>
