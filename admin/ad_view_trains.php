<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';


if($_GET["status"]){
    $status = $_GET["status"];
}

$route = "SELECT train_name, train_no FROM trains WHERE status = '$status' ORDER BY train_no DESC LIMIT 7";
$query = pg_query($conn, $route);
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
    <link rel="stylesheet" href="../design/ad_users.css">
    <title>Trains</title>
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
                        <li><a href="ad_train_options.php"  id="ta_selected" >TRAINS</a></li>
                        <li><a href="ad_station_options.php" >STATIONS</a></li>
                        <li><a href="ad_view_options.php" >VIEW USERS</a></li>
                        <li><a href="ad_more_options.php">MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="colb">
                <br>
            <table style="width:100%">
                                
                                <tr>
                                    <th>Train No.</th>
                                    <th style="width:500px">Train Name</th>
                                    <th >Action</th>
                                </tr>
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){

                            $train_no = htmlspecialchars($row['train_no']);
                            $train_name = htmlspecialchars($row['train_name']);
                            
                            ?>
                                 <tr>
                                <td><?php echo htmlspecialchars($train_no); ?><br></td>
                                <td><?php echo htmlspecialchars($train_name); ?></td>
                                <td ><?php echo "<button onclick=\"location.href='ad_train_details.php?train_no=$train_no'\" type=\"button\" id=\"unblock\">VIEW DETAILS</button>";?></td>
                            </tr>  
                        <?php
                        }
                    }
                ?>
                </table>
                <?php 
                    if ($count == 0 && $status == 'Active'){
                        ?>

                        <p class="no-user">
                            No Active Train Found !!!
                        </div>
                        <?php
                    }
                    if ($count == 0 && $status == 'In-active'){
                        ?>

                        <p class="no-user">
                            No In-active Train Found !!!
                        </div>
                        <?php
                    }
                    pg_close($conn);
                ?>
            </div>
        </footer>
    </div>
</body>
</html>
