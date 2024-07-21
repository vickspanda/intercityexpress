<?php
    session_start();
    echo $_SESSION['train_no'].'<br>';
    echo $_SESSION['train_fare'].'<br>';
    echo $_SESSION['doj'].'<br>';
    echo $_SESSION['dep_time'].'<br>';
    echo $_SESSION['arr_time'].'<br>';
    echo $_SESSION['coach_no'].'<br>';
    echo $_SESSION['endStn'].'<br>';
    echo $_SESSION['startStn'].'<br>';
    echo $_SESSION['userType'].'<br>';
    echo $_SESSION['username'].'<br>';
    echo $_POST["traveler_name"].'<br>';
    echo $_POST['user_gender'].'<br>';
    echo $_POST['age'].'<br>';
?>