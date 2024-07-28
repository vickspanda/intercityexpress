<?php    
    session_start();
    include 'connect.php';
    if(isset($_SESSION['pass_username'])){
        $username = $_SESSION['pass_username'];
        $userType = 'passenger';
        $shift  = 'passenger';
    }
    
    if(isset($_SESSION['emp_username'])){
        $username = $_SESSION['emp_username'];
        $userType = 'employee';
        $shift  = 'emp';

    }

    if(isset($_SESSION['ta_username'])){
        $username = $_SESSION['ta_username'];
        $userType =  'travel_agent';
        $shift  = 'ta';

    }
    if(!$username){
        echo '<script>window.location.href="../index.html";</script>';
    }

    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $userType = $_POST['userType'];
        $subject = $_POST['subject'];
        $content = $_POST['content'];
    }

    $submitQuery = "INSERT INTO feedback (username, user_type, subject, content) VALUES ($1,$2,$3,$4);";
    $submitExe = pg_query_params($conn, $submitQuery, array($username,$userType,$subject,$content));

    if($submitExe){
        echo '<script>window.alert("Your Feedback has been Submitted Successfully!!!");</script>';
    }else{
        echo '<script>window.alert("Got some technical Failure !!!");</script>';
    }
    echo '<script>window.location.href="../'.$userType.'/'.$shift.'_dashboard.php";</script>';

?>