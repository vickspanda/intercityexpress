<?php
session_start();
include '../process/connect.php';

if(isset($_SESSION['admin_username'])){
    $admin_username = $_SESSION['admin_username'];
}


if(!$admin_username){
    echo '<script>window.location.href="../admin/index.html";</script>';
}


$user = "SELECT SUM(payment.ta_comm) as tta_comm, SUM(payment.total_fare) as ttotal_fare, SUM(payment.ticket_fare) as tticket_fare FROM payment WHERE payment.status = 'Successful'";
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
    <title>Our Earnings</title>
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
                <h1 style="text-align:center;width:100%">Our Earnings</h1>
            <table style="width:100%;text-align:center;align-items:center;margin-top:100px">
                <tr>
                    <th style="width:420px;text-align: center;">Event</th>
                    <th style="width:420px;text-align:center">Amount Earned</th>
                </tr>
                <tr>
                                <td style='text-align:center'></td>
                                <td style="text-align:center"></td>
                                
                            </tr> 
                                
                <?php 
                    if($count > 0) {
                        $row  = pg_fetch_assoc($query);
                            $name = htmlspecialchars($row['ta_name']);
                            $username = htmlspecialchars($row['username']);
                            $ttotal_fare = htmlspecialchars($row['ttotal_fare']);
                            $tta_comm = htmlspecialchars($row['tta_comm']);

                            ?>
                            
                                 <tr>
                                <td style='text-align:center'>Total Fare Earned</td>
                                <td style="text-align:center">Rs. <?php echo htmlspecialchars($ttotal_fare);?></td>
                                
                            </tr>  
                            <tr>
                                <td style='text-align:center'></td>
                                <td style="text-align:center"></td>
                                
                            </tr>  
                            <tr>
                                <td style='text-align:center'>Total Agent's Commission</td>
                                <td style="text-align:center">-    Rs. <?php echo htmlspecialchars($tta_comm);?></td>
                                
                            </tr>  
                            <tr>
                                <td style='text-align:center'></td>
                                <td style="text-align:center"></td>
                                
                            </tr> 
                            <tr>
                                <th style='text-align:center'>Total Earnings</th>
                                <th style="text-align:center">Rs. <?php echo htmlspecialchars($ttotal_fare-$tta_comm);?></th>
                                
                            </tr>  
                            <tr>
                                <td style='text-align:center'></td>
                                <td style="text-align:center"></td>
                                
                            </tr> 
                            
                            
                        <?php
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