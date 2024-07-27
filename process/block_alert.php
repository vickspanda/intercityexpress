<?php
    session_start();


    include '../process/connect.php';

$userType = $_SESSION["userType"];
if($userType === 'passenger'){
    $col_name = 'name';
    $login_page = 'logout.php?user=../passenger/';
    $username = $_SESSION["pass_username"];
}else if($userType === 'travel_agent'){
    $col_name = 'ta_name';
    $login_page = 'logout.php?user=../travel_agent/';
    $username = $_SESSION["ta_username"];
}else if($userType === 'employee'){
    $col_name = 'emp_name';
    $login_page = 'logout.php?user=../employee/';
    $username = $_SESSION["emp_username"];
}
if(isset($_SESSION['username'])){
    $username = $_SESSION["username"];
}
if(!$username)  {
    echo '<script>window.location.href="../index.html"</script>';
  }

$get_name_query = "SELECT $col_name FROM $userType WHERE username = $1";
$name_result = pg_query_params($conn, $get_name_query, array($username));

if ($name_result && pg_num_rows($name_result) > 0) {
    $name_row = pg_fetch_row($name_result);
    $name = $name_row[0];
}
?>


<!DOCTYPE html>
    <head>
        <title>Dashbaord</title>
        <link rel="stylesheet" href="../design/ta_alert.css">
        <link rel="stylesheet" href="../design/home.css">
    </head>
    <body>
        <div class="background"></div>
        <div class="login_form">
            <form id="signUpForm" method="post" action="<?php echo $login_page?>">
                <br><br>
                <div class="lbl2">
                    <label>Your Services have been Suspended !</label>
                </div>
                <div class="credentials_forgot">
                    <br>
                    <h2> Dear <?php echo htmlspecialchars($name);?> ,</h2><h2>Your Account has been Suspended by the InterCity Express Authority !!! Please Contact the Authority for More Information regarding this ...</h2>
                    
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