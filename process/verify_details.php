<?php
    session_start();
    $train_no = $_SESSION['train_no'];
    $train_fare = $_SESSION['train_fare'];
    $doj = $_SESSION['doj'];
    $dep_time = $_SESSION['dep_time'];
    $arr_time = $_SESSION['arr_time'];
    $coach_no = $_SESSION['coach_no'];
    $endStn = $_SESSION['endStn'];
    $startStn = $_SESSION['startStn'];
    $userType = $_SESSION['userType'];
    $username = $_SESSION['username'];
    $user_name = $_POST["traveler_name"];
    $_SESSION['user_name'] = $user_name;
    $user_gender = $_POST['user_gender'];
    $_SESSION['user_gender'] = $user_gender;
    $user_age = $_POST['age'];
    $_SESSION['user_age'] = $user_age;
    $user_mob = $_POST['mobile_no'];
    $_SESSION['user_mob'] = $user_mob;
    $user_email = $_POST['email'];
    $_SESSION['user_email'] = $user_email;

    if(!$username){
        echo "<script>window.location.href='../index.html'</script>";
    }
    include 'connect.php';
    include 'getUserStatus.php';


    $get_train_name = "SELECT train_name FROM trains WHERE train_no = $1";
    $get_train_execute = pg_query_params($conn,$get_train_name,array($train_no));
    if($get_train_execute){
        $train_row = pg_fetch_assoc($get_train_execute);
        $train_name = $train_row['train_name'];
    }
    $get_stn_name = "SELECT station_name FROM stations WHERE station_code = $1";
    $get_start_execute = pg_query_params($conn,$get_stn_name,array($startStn));
    if($get_start_execute){
        $start_row = pg_fetch_assoc($get_start_execute);
        $from_station = $start_row['station_name'];
    }
    else{
        echo 'Error: 1';
    }
    $get_end_execute = pg_query_params($conn,$get_stn_name,array($endStn));
    if($get_end_execute){
        $end_row = pg_fetch_assoc($get_end_execute);
        $to_station = $end_row['station_name'];
    }
    else{
        echo 'Error: 2';
    }

    $get_comm_conn = "SELECT comm_conn FROM limits WHERE user_type = $1";
    $get_comm_conn_execute = pg_query_params($conn,$get_comm_conn,array($userType));
    if($get_comm_conn_execute){
        $comm_conn_row = pg_fetch_assoc($get_comm_conn_execute);
        if($userType === 'travel_agent'){
            $ta_comm = $comm_conn_row['comm_conn'];
        }else if ($userType === 'employee'){
            $emp_conn = $comm_conn_row['comm_conn'];
        }
    }
    else{
        echo 'Error: 2';
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/verify_details.css">
    <title>Verify Details</title>
</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
                <h1>Verify Details</h1>
                <table style="width:90%">
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
                                <td>Username:</td>
                                <td><?php echo htmlspecialchars($username);?></td>
                            </tr>
                            <tr>
                                <td>Traveler's Name</td>
                                <td><?php echo htmlspecialchars($user_name);?></td>
                                <td>Traveler's Age:</td>
                                <td><?php echo htmlspecialchars($user_age);?></td>
                            </tr>
                            <tr>
                                <td>Email Id</td>
                                <td><?php echo htmlspecialchars($user_email);?></td>
                                <td>Mobile No.:</td>
                                <td><?php echo htmlspecialchars($user_mob);?></td>
                            </tr>
                            
                            <tr>
                                <td> Gender:</td>
                                <td><?php echo htmlspecialchars($user_gender);?></td>                                
                                <td>Ticket Fare:</td>
                                <td style="text-align:right">Rs. <?php echo htmlspecialchars($train_fare);?></td>
                            </tr>
                            <?php
                                if($userType === 'passenger'){
                                    $total_fare = $train_fare;
                                    $_SESSION['total_fare'] = $total_fare;
                                    $_SESSION['ticket_fare'] = $train_fare;
                                }
                                else if($userType === 'travel_agent'){
                                    $ta_comm = $train_fare * $ta_comm/100;
                                    $total_fare = $train_fare + $ta_comm;
                                    $_SESSION['total_fare'] = $total_fare;
                                    $_SESSION['ticket_fare'] = $train_fare;
                                    $_SESSION['ta_comm'] = $ta_comm;

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
                                $emp_conn = $train_fare * $emp_conn/100;
                                $total_fare = $train_fare - $emp_conn;
                                $_SESSION['total_fare'] = $total_fare;
                                $_SESSION['ticket_fare'] = $train_fare;
                                $_SESSION['emp_conn'] = $emp_conn;
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
                                <th>Total Fare:</th>
                                <th style="text-align:right">Rs. <?php echo htmlspecialchars($total_fare);?></th>
                            </tr>
                </table>
                <br>
        <button onclick="location.href='make_payment.php'" type="button" id="signup1">Proceed</button>
        <button onclick="location.href='cancel_transaction.php'" type="button" id="signup1">Cancel</button><br>
        <br>
    </div>
    
</body>
</html>
<?php
pg_close($conn);

?>