<?php
    session_start();
    $_SESSION['train_no'] = $_POST['train_no'].'<br>';
    $_SESSION['train_fare'] = $_POST['train_fare'].'<br>';
    $_SESSION['doj'] = $_POST['doj'].'<br>';
    $_SESSION['dep_time'] = $_POST['dep_time'].'<br>';
    $_SESSION['arr_time'] = $_POST['arr_time'].'<br>';
    $_SESSION['coach_no'] = $_POST['coach_no'].'<br>';
    $_SESSION['endStn'] = $_POST['endStn'].'<br>';
    $_SESSION['startStn'] = $_POST['startStn'].'<br>';
    

?>
<!DOCTYPE html>
    <head>
        <title>User Login</title>
        <link rel="stylesheet" href="../design/login_page.css">
        <link rel="stylesheet" href="../design/home.css">
    </head>
    <body>

        <div class="background"></div>
        <div class="login_form">
            <form method="post" action="user_validate.php">
                <br><br>
                <div class="lbl3">
                    <label>User Login</label><br><br><br>
                </div>
                <div class="credentials">
                    <input type="username" name="username" placeholder="Username" autofocus required>
                    <br><br><br>
                    <input type="password" name="password" placeholder="Password" required>
                    <br><br><br>
                
                <div class="sec_book">
                        <select name="userType" required>
                            <option value="" disabled selected hidden>Select Your User Type</option>
                            <option value="passenger">Passenger</option>
                            <option value="employee">Employee</option>
                            <option value="travel_agent">Travel Agent</option>
                        </select>
                    </div>
                    <br><br>
                </div>
                <div class="submit2">
                    <input type="submit" value="Sign In">
                    
                    <br><br><br>
                </div>
        </div>
    </body>
</html>
