<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';


if(isset($_GET["status"])){
    $status = $_GET["status"];
}

$route = "SELECT route_code, start_station, end_station, distance FROM routes WHERE status = '$status' ORDER BY route_code DESC LIMIT 7";
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
    <title>Routes</title>
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
                        <li><a href="ad_station_options.php" >STATIONS</a></li>
                        <li><a href="ad_view_options.php" >VIEW USERS</a></li>
                        <li><a href="ad_more_options.php" id="ta_selected" >MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="colb">
                <br>
            <table style="width:100%">
                                
                                <tr>
                                    <th>Route Code</th>
                                    <th style="width:250px">Start</th>
                                    <th style="width:250px">End</th>
                                    <th >Distance</th>
                                </tr>
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){

                            $start_station = htmlspecialchars($row['start_station']);

                            $station = "SELECT station_name FROM stations WHERE station_code = $1";
                            $get_from_result = pg_query_params($conn, $station, array($start_station));
                            if ($get_from_result) {
                                $from_row = pg_fetch_assoc($get_from_result);
                                $start_station = $from_row['station_name'];
                            } else {
                                die("Error fetching station name: " . pg_last_error($conn));
                            }
                            $route_code = htmlspecialchars($row['route_code']);
                            $end_station = htmlspecialchars($row['end_station']);
                            $get_to_result = pg_query_params($conn, $station, array($end_station));
                            if ($get_to_result) {
                                $to_row = pg_fetch_assoc($get_to_result);
                                $end_station = $to_row['station_name'];
                            } else {
                                die("Error fetching station name: " . pg_last_error($conn));
                            }
                            $distance = htmlspecialchars($row['distance']);
                            ?>
                                 <tr>
                                <td><?php echo htmlspecialchars($route_code); ?><br></td>
                                <td><?php echo htmlspecialchars($start_station); ?></td>
                                <td>
                                    <?php
                                        echo htmlspecialchars($end_station);
                                    ?>

                                </td>
                                <td ><?php echo htmlspecialchars($distance) . ' kms';?></td>
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
                            No Active Route Found !!!
                        </div>
                        <?php
                    }
                    if ($count == 0 && $status == 'In-active'){
                        ?>

                        <p class="no-user">
                            No In-Active Route Found !!!
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
