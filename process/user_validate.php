<?php 
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    if (!$username || !$password || !$userType) {
        echo '<script>window.location.href="../index.html";</script>';
        exit();
    }

    $_SESSION['userType'] = $userType;
    $_SESSION['book'] = TRUE;


    if($userType === 'passenger'){
        $_SESSION['pass_username'] = $username;
        $_SESSION['pass_password'] = $password;
        echo '<script>window.location.href="../passenger/passenger_validate.php";</script>';
    }
    if($userType === 'travel_agent'){
        $_SESSION['ta_username'] = $username;
        $_SESSION['ta_password'] = $password;
        echo '<script>window.location.href="../travel_agent/ta_validate.php";</script>';
    }
    if($userType === 'employee'){
        $_SESSION['emp_username'] = $username;
        $_SESSION['emp_password'] = $password;
        echo '<script>window.location.href="../employee/emp_validate.php";</script>';
    }    
?>