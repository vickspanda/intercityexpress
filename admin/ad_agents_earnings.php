<?php
session_start();
include '../process/connect.php';

if(isset($_SESSION['admin_username'])){
    $admin_username = $_SESSION['admin_username'];
}


if(!$admin_username){
    echo '<script>window.location.href="../admin/index.html";</script>';
}


$user = "SELECT tickets_ta.username, travel_agent.ta_name, SUM(payment.ta_comm) as tta_comm, SUM(payment.total_fare) as ttotal_fare, SUM(payment.ticket_fare) as tticket_fare FROM tickets, tickets_ta, payment, travel_agent WHERE tickets.ticket_no = payment.ticket_no AND tickets.ticket_no = tickets_ta.ticket_no AND tickets_ta.username = travel_agent.username AND tickets.status = 'Confirmed' AND tickets.user_type = 'travel_agent' GROUP BY tickets_ta.username, travel_agent.ta_name LIMIT 10";
        $query = pg_query($conn, $user);
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
    <title>Agent's Earnings</title>
    <script src="../script/admin_logout.js" defer></script>

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
                                <li><a href="../admin/ad_more_options.php" id="ta_selected">MORE OPTIONS</a></li>
                                <li><a href="#" onclick="logout()">LOG OUT</a></li>
                            </ul>
                        </div>
            </div>
            
            <div class="colb">
                <br>
                <h2 style="text-align:center;width:100%">Agent's Earnings</h2>
            <table style="width:100%">
                <tr>
                    <th>Username</th>
                    <th>Agent's Name</th>
                    <th style='text-align:center;width:200px'>Total Ticket Fare</th>
                    <th style='text-align:center;width:200px'>Total Commission</th>
                    <th style='text-align:center;width:150px'>Total Fare</th>
                </tr>
                                
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){
                            $name = htmlspecialchars($row['ta_name']);
                            $username = htmlspecialchars($row['username']);
                            $ttotal_fare = htmlspecialchars($row['ttotal_fare']);
                            $tticket_fare = htmlspecialchars($row['tticket_fare']);
                            $tta_comm = htmlspecialchars($row['tta_comm']);

                            ?>
                            
                                 <tr>
                                    <td><?php echo htmlspecialchars($username); ?></td>
                                <td style='width:220px'><?php echo htmlspecialchars($name); ?></td>
                                <td style='text-align:center'>Rs. <?php echo htmlspecialchars($tticket_fare);?></td>
                                <td style='text-align:center'>Rs. <?php echo htmlspecialchars($tta_comm);?></td>
                                <th style="text-align:center">Rs. <?php echo htmlspecialchars($ttotal_fare);?></th>
                                
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
                            No Record Found !!!
                        </div>
                        <?php
                    }
                ?>
            </div>
        </footer>
        <br><br>
        <div style="text-align: center;" class="submit1">
                <button onclick="location.href = 'ad_more.php'" id="signup1" type="button">BACK</button>
            </div>
        <br><br>

    </div>
</body>
</html>
<?php
pg_close($conn);
?>
