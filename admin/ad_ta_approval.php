<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';


$blocked_ta = "SELECT ta_name, username FROM travel_agent WHERE status='Not-verified' LIMIT 7";
$ta_query = pg_query($conn, $blocked_ta);
if (!$ta_query) {
    die("Query failed: " . pg_last_error());
}

$ta_count = pg_num_rows($ta_query);



pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/ad_users.css">
    <title>Pending Approvals</title>
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
                        <li><a href="ad_ta_options.php"  id="ta_selected">TRAVEL AGENTS</a></li>
                        <li><a href="ad_emp_options.php">EMPLOYEES</a></li>
                        <li><a href="ad_train_options.php">TRAINS</a></li>
                        <li><a href="ad_station_options.php">STATIONS</a></li>
                        <li><a href="ad_view_options.php">VIEW USERS</a></li>
                        <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="colb">
                <br>
            <table style="width:100%">
                                
                                <tr>
                                    <th>Userame</th>
                                    <th style="width:320px">Name</th>
                                    <th>Action 1</th>
                                    <th>Action 2</th>
                                </tr>
                <?php 
                    $count = 0;
                    if($ta_count > 0) {
                        while ($ta_row = pg_fetch_assoc($ta_query)){
                            $ta_name = htmlspecialchars($ta_row['ta_name']);
                            $ta_username = htmlspecialchars($ta_row['username']);
                            ?>
                                 <tr>
                                <td><?php echo htmlspecialchars($ta_username); ?><br></td>
                                <td><?php echo htmlspecialchars($ta_name); ?></td>
                                <td><?php echo "<button onclick=\"location.href='un-block_user.php?ta_pend_username=$ta_username'\" type=\"button\" id=\"unblock\">APPROVE</button>"; ?></td>
                                <td><?php echo "<button onclick=\"location.href='ad_ta_profile.php?ta_pend_username=$ta_username'\" type=\"button\" id=\"unblock\">VIEW DETAILS</button>";?></td>
                            </tr>  
                        <?php
                         $count = $count + 1;
                         if($count == 7){
                            break;
                        }

                        }
                    }
                ?>
                </table>
                <?php 
                    if ($ta_count == 0){
                        ?>

                        <p class="no-user">
                            No Registration Request Found !!!
                        </div>
                        <?php
                    }
                ?>
            </div>
        </footer>
        <div class="signup">
            <br><br>
        </div>
    </div>
</body>
</html>
