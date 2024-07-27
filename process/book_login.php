<?php
    session_start();
    if(isset($_POST['train_no'])){
        $_SESSION['train_no'] = $_POST['train_no'];
    }
    if(isset($_POST['train_fare'])){
        $_SESSION['train_fare'] = $_POST['train_fare'];
    }
    if(isset($_POST['doj'])){
        $_SESSION['doj'] = $_POST['doj'];
    }
    if(isset($_POST['dep_time'])){
        $_SESSION['dep_time'] = $_POST['dep_time'];
    }
    if(isset($_POST['arr_time'])){
        $_SESSION['arr_time'] = $_POST['arr_time'];
    }
    if(isset($_POST['coach_no'])){
        $_SESSION['coach_no'] = $_POST['coach_no'];
    }
    if(isset($_POST['endStn'])){
        $_SESSION['endStn'] = $_POST['endStn'];
    }
    if(isset($_POST['startStn'])){
        $_SESSION['startStn'] = $_POST['startStn'];
    }
    if(isset($_POST['total_seats'])){
        $_SESSION['total_seats'] = $_POST['total_seats'];
    }
    

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
                        <select name="userType" onblur="validateDateRange()" required>
                            <option value="" disabled selected hidden>Select Your User Type</option>
                            <option value="passenger">Passenger</option>
                            <option value="employee">Employee</option>
                            <option value="travel_agent">Travel Agent</option>
                        </select>
                    </div>
                    <br><br>
                </div>
                <div class="submit1">
                    <input type="submit" value="Sign In">
                    <button type="button" onclick="location.href='cancel_transaction.php'">Cancel</button>
                    <br><br><br>
                </div>
        </div>
    </body>
</html>
