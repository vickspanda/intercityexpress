<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';


include '../process/connect.php';

$user = "SELECT * FROM feedback ORDER BY id DESC LIMIT 10";
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
    <link rel="stylesheet" href="../design/list_tickets.css">
    <title>View Feedbacks</title>
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
                        <li><a href="ad_view_options.php" >VIEW USERS</a></li>
                        <li><a href="ad_more_options.php"  id="ta_selected">MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="colb">
                <br>
            <table style="width:100%">
                <h1 style="text-align: center;">View Feedbacks</h1>
                                
                                <tr>
                                    <th>Userame</th>
                                    <th style="text-align:left">User Type</th>
                                    <th style="text-align:left;width:320px">Subject</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                <?php 
                    if($count > 0) {
                        while ($row = pg_fetch_assoc($query)){
                            $user_type = htmlspecialchars($row['user_type']);
                            $username = htmlspecialchars($row['username']);
                            $subject = htmlspecialchars($row['subject']);
                            $id = htmlspecialchars($row['id']);


                            ?>
                                 <tr>
                                <td><?php echo htmlspecialchars($username); ?><br></td>
                                <td><?php 
                                    if($user_type === 'passenger'){
                                        echo 'Passenger';
                                    }else if($user_type === 'travel_agent'){
                                        echo 'Travel Agent';
                                    }else if($user_type === 'employee'){
                                        echo 'Employee';
                                    }
                                    ?></td>
                                <td><?php echo htmlspecialchars($subject); ?></td>
                                <td>
                                    <form method="post" action="ad_view_content.php">
                                        <input type="text" name="username" value="<?php echo $username;?>" hidden>
                                        <input type="text" name="userType" value="<?php echo $user_type;?>" hidden>
                                        <input type="text" name="id" value="<?php echo $id;?>" hidden>
                                        <input type="submit" id="unblock" value="VIEW DETAILS">

                                    </form>
                                </td>
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
                            No FeedBack Found !!!
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
