<?php
    session_start();
    $train_no = $_SESSION['train_no'];
    $doj = $_SESSION['doj'];
    $starts_on =  $_SESSION['dep_time'];
    $ends_on = $_SESSION['arr_time'];
    $coach_no = $_SESSION['coach_no'];
    $drop_stn = $_SESSION['endStn'];
    $board_stn = $_SESSION['startStn'];
    $userType = $_SESSION['userType'];
    $username = $_SESSION['username'];
    $user_name = $_SESSION["user_name"];
    $user_gender = $_SESSION['user_gender'];
    $user_age = $_SESSION['user_age'];
    $ticket_fare = $_SESSION['ticket_fare'];
    $total_fare = $_SESSION['total_fare'];
    $ta_comm = $_SESSION['ta_comm'];
    $emp_conn = $_SESSION['emp_conn'];
    $user_mob = $_SESSION['user_mob'];
    $user_email = $_SESSION['user_email'];

    if(!$username){
        echo "<script>window.location.href='../index.html'</script>";
    }
    include 'connect.php';
    include 'getUserStatus.php';



?>
<!DOCTYPE html>
    <head>
        <title>Make Payment</title>
        <link rel="stylesheet" href="../design/login_page.css">
        <link rel="stylesheet" href="../design/home.css">
    </head>
    <body>

        <div class="background"></div>
        <div class="login_form1">
            <form method="post" action="book_ticket.php">
                <br><br>
                <div class="lbl3">
                    <label>Make Payment</label><br><br><br>
                </div>
                <div class="credentials">
                    <table style="width:90%">
                        <tr>
                            <td>Ticket Fare:</td>
                            <td>Rs. <?php echo htmlspecialchars($ticket_fare);?></td>
                        </tr>
                        <?php 
                            if($userType === 'travel_agent')
                            {
                        ?>
                        <tr>
                            <td>Commission:</td>
                            <td>Rs. <?php echo htmlspecialchars($ta_comm);?></td>
                        </tr>
                        <?php 
                            }
                            if($userType === 'employee')
                            {
                        ?>
                        <tr>
                            <td>Concession:</td>
                            <td>Rs. <?php echo htmlspecialchars($emp_conn);?></td>
                        </tr>
                        <?php 
                            }
                        ?>
                        <tr>
                            <td>Total Fare</td>
                            <td>Rs. <?php echo htmlspecialchars($total_fare);?></td>
                        </tr>
                        <tr>
                            <td colspan = 2><input type="text" name="upi" placeholder = "Enter Your UPI ID to Proceed" autofocus required>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="submit1">
                    <input type="submit" value="Proceed">
                    <button type="button" onclick="location.href='cancel_transaction.php'">Cancel</button>
                    <br><br><br>
                </div>
        </div>
    </body>
</html>
