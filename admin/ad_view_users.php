<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';


include '../process/connect.php';


if(isset($_GET['pass'])){
    $userType = 'passenger';
    $title = 'Passengers';
    $us_name = 'name';
    $id = 'pass_id';
    $next = 'pass_list';
    $redirect = 'ad_pass_profile.php';
}

if(isset($_GET['emp'])){
    $userType = 'employee';
    $title = 'Employees';
    $us_name = 'emp_name';
    $id = 'emp_uid';
    $next = 'emp_list';
    $redirect = 'ad_emp_profile.php';
}

if(isset($_GET['ta'])){
    $userType = 'travel_agent';
    $title = 'Travel Agents';
    $us_name = 'ta_name';
    $id = 'ta_uid';
    $next = 'ta_list';
    $redirect = 'ad_ta_profile.php';
}


$user = "SELECT $us_name, username, status FROM $userType WHERE status = 'Active' ORDER BY $id DESC LIMIT 7";
$query = pg_query($conn, $user);
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
    <title><?php echo $title;?> List</title>
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
                        <li><a href="ad_station_options.php">STATIONS</a></li>
                        <li><a href="ad_view_options.php"  id="ta_selected">VIEW USERS</a></li>
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
                                    <th style="text-align:center">Action 1</th>
                                    <th style="text-align:center">Action 2</th>
                                </tr>
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){
                            $name = htmlspecialchars($row[$us_name]);
                            $username = htmlspecialchars($row['username']);
                            ?>
                                 <tr>
                                <td><?php echo htmlspecialchars($username); ?><br></td>
                                <td><?php echo htmlspecialchars($name); ?></td>
                                <td>
                                    <?php
                                        if($row['status'] === 'Active'){
                                            echo "<button onclick=\"location.href='un-block_user.php?$next=$username'\" type=\"button\" id=\"unblock\">BLOCK</button>";
                                        }
                                        else{
                                            echo htmlspecialchars($row['status']);
                                        }
                                    ?>

                                </td>
                                <td><?php echo "<button onclick=\"location.href='$redirect?$next=$username'\" type=\"button\" id=\"unblock\">VIEW DETAILS</button>";?></td>
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
