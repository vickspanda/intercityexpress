<?php    
    session_start();
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
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/updateContact.css">
    <title>Feedback</title>
</head>
<body>
    <div class="bg-image"></div>
    <div class="create_account">
        <form id="signUpForm" action="feedbackSubmit.php" method="post">
            <br><br>
            <div class="heading">
                <label>Feedback Form</label>
            </div>
            <br><br>

                <div class="col1">
                    <div class="fields1">
                        <input type="text" id="username" name="username" maxlength="30" value="<?php echo $username;?>" readonly required><br><br><br>
                        <input type="text" id="userType" name="userType" maxlength="30" value="<?php echo $userType;?>" hidden required>
                        <input type="text" id="shift" name="shift" maxlength="30" value="<?php echo $shift;?>" hidden required>
                        <input type="text" id="subject" name="subject" placeholder="Enter Subject Here" maxlength="100" required><br><br><br>
                        <textarea id="content" name="content" placeholder="Enter Feedback Content Here" maxlength="2000" rows="10" cols="50" required></textarea><br><br>
                    </div>
                </div>
                <br>
            <div class="signup">
                <input type="submit" value="Submit">
                <button onclick="location.href = '../<?php echo $userType;?>/<?php echo $shift;?>_dashboard.php'" type="button">Cancel</button><br><br><br>
            </div>
            <br>
        </form>
    </div>
    <script src="../script/pass_update.js"></script>
</body>
</html>
