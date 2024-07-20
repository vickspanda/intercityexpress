<?php
    session_start();
    $ta_username = $_SESSION["ta_username"];
    include '../process/!ta_username.php';

    include '../process/connect.php';

$ta_conn = $conn;
$get_ta_name_query = "SELECT ta_name FROM travel_agent WHERE username = $1";
$ta_name_result = pg_query_params($ta_conn, $get_ta_name_query, array($ta_username));

if ($ta_name_result && pg_num_rows($ta_name_result) > 0) {
    $ta_name_row = pg_fetch_row($ta_name_result);
    $ta_name = $ta_name_row[0];
}
?>


<!DOCTYPE html>
    <head>
        <title>Approval Pending</title>
        <link rel="stylesheet" href="../design/ta_alert.css">
        <link rel="stylesheet" href="../design/home.css">
    </head>
    <body>
        <div class="background"></div>
        <div class="login_form">
            <form id="signUpForm" method="post" action="../process/logout.php?user=../travel_agent/">
                <br><br>
                <div class="lbl2">
                    <label>You Are Not Verified !</label>
                </div>
                <div class="credentials_forgot">
                    <br>
                    <h2> Dear <?php echo htmlspecialchars($ta_name);?> ,</h2><h2>Your Registration is pending at the Administration Side for the Verification and Approval. You can Log into the System once your Registration is Verified and Approved by the Administration.</h2>
                    
                    <h2>Inconvenience is regretted !!!</h2>
                    <br>
                    
                </div>
                <div class="submit2">
                    <input type="submit" value="Okay">
                    <br><br><br>
                </div>
            </form>
        </div>
    </body>
</html>


<?php
    pg_close($ta_conn);
?>