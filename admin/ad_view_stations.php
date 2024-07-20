<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';


include '../process/connect.php';


$status = $_GET["status"];
$user = "SELECT station_code, station_name, state, no_of_platform FROM stations WHERE status = $1 ORDER BY station_code DESC LIMIT 7";
$query = pg_query_params($conn, $user, array($status));
if (!$query) {
    die("Query failed: " . pg_last_error());
}

$count = pg_num_rows($query);



pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/ad_users.css">
    <title>Stations</title>
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
                        <li><a href="ad_station_options.php" id="ta_selected">STATIONS</a></li>
                        <li><a href="ad_view_options.php" >VIEW USERS</a></li>
                        <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="colb">
                <br>
            <table style="width:100%">
                                
                                <tr>
                                    <th>Station Code</th>
                                    <th style="width:220px">Station Name</th>
                                    <th style="text-align:center">State</th>
                                    <th style="text-align:center">No. of Platforms</th>
                                </tr>
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){
                            $station_name = htmlspecialchars($row['station_name']);
                            $station_code = htmlspecialchars($row['station_code']);
                            $state = htmlspecialchars($row['state']);
                            $no_of_platform = htmlspecialchars($row['no_of_platform']);
                            ?>
                                 <tr>
                                <td><?php echo htmlspecialchars($station_code); ?><br></td>
                                <td><?php echo htmlspecialchars($station_name); ?></td>
                                <td>
                                    <?php
                                        echo htmlspecialchars($state);
                                    ?>

                                </td>
                                <td style="text-align:center"><?php echo htmlspecialchars($no_of_platform);?></td>
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
                            No <?php echo $status?> Station Found !!!
                        </div>
                        <?php
                    }
                ?>
            </div>
        </footer>
    </div>
</body>
</html>
