<?php

session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';


include '../process/connect.php';
$username = $_POST['username'];
$user_type = $_POST['userType'];
$id = $_POST['id'];

$getContent = "SELECT * FROM feedback WHERE username = $1 AND user_type = $2 AND id = $3";
$getContentExe = pg_query_params($conn,$getContent, array($username,$user_type,$id));
if (!$getContentExe) {
    die("Query failed: " . pg_last_error());
}

$user = "SELECT * FROM $user_type WHERE username = $1";
$query = pg_query_params($conn, $user,array($username));
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
    <link rel="stylesheet" href="../design/viewSchedule.css">

    <title>View Feedback</title>
    <script src="../script/admin_logout.js" defer></script>

</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account1">

    <h1 style="text-align:center">View Feedback</h1>
        <footer>

            <table>
                <?php
                    $row = pg_fetch_assoc($getContentExe);
                    $row1 = pg_fetch_assoc($query);

                    $user_type = htmlspecialchars($row['user_type']);
                    $username = htmlspecialchars($row['username']);
                    $subject = htmlspecialchars($row['subject']);
                    $content = htmlspecialchars($row['content']);
                    $id = htmlspecialchars($row['id']);
                ?>

                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($username); ?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php
                    if($user_type === 'passenger'){
                        $name = htmlspecialchars($row1['name']);
                        echo $name;
                    }else if($user_type === 'travel_agent'){
                        $name = htmlspecialchars($row1['ta_name']);
                        echo $name;
                    }else if($user_type === 'employee'){
                        $name = htmlspecialchars($row1['emp_name']);
                        echo $name;
                    }?>
                    </td>
                </tr>
                <tr>
                    <td>User Type</td>
                    <td><?php 
                    if($user_type === 'passenger'){
                        echo 'Passenger';
                    }else if($user_type === 'travel_agent'){
                        echo 'Travel Agent';
                    }else if($user_type === 'employee'){
                        echo 'Employee';
                    }
                    ?></td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td><?php echo htmlspecialchars($subject); ?></td>
                </tr>
                <tr>
                    <td>Feedback</td>
                    <td><?php echo htmlspecialchars($content); ?></td>
                </tr>
                
            </table>
        </footer>
        <br><br>
        <div style="text-align: center;" class="submit1">
                <button onclick="location.href = 'ad_view_feedback.php'" id="signup1" type="button">BACK</button>
            </div>
        <br><br>
    </div>
</body>
</html>
