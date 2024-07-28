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
    $total_seats = $_SESSION['total_seats'];
    $user_mob = $_SESSION['user_mob'];
    $user_email = $_SESSION['user_email'];
    $upi = $_POST['upi'];
    if(!$username){
        echo "<script>window.location.href='../index.html'</script>";
    }
    include 'connect.php';
    include 'getUserStatus.php';


    pg_query($conn, "BEGIN");


    $counter_query = "SELECT counter FROM ticket_no_generator ORDER BY ticket_id DESC LIMIT 1";
    $counter_result = pg_query($conn, $counter_query);

    if ($counter_result) {
        $row = pg_fetch_assoc($counter_result);
        $counter = $row['counter'];

        $newCounter = $counter + 1;
        $updateCounter = "INSERT INTO ticket_no_generator (counter) VALUES ($newCounter)";
        $newResult = pg_query($conn, $updateCounter);

        if (!$newResult) {
            pg_query($conn, "ROLLBACK"); // Rollback the transaction if updateCounter fails
            die("Error updating counter: " . pg_last_error($conn));
        }

        $ticket_no = 'TKT' . $counter;
        $status = 'Confirmed';
        $insert_into_tickets = "INSERT INTO tickets VALUES ($1,$2,$3,$4,$5,$6,$7,$8)";
        $tickets_array = array($ticket_no,$train_no,$status,$board_stn,$drop_stn,$starts_on,$ends_on,$userType);
        $tickets_execute = pg_query_params($conn,$insert_into_tickets,$tickets_array);
        
        if ($tickets_execute) {
            $_SESSION['ticket_no'] = $ticket_no;
            if($userType === 'passenger')
            {
                $_SESSION['pass_username'] = $username;
                $insert_into_sec = "INSERT INTO tickets_pass VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9)";
                $sec_array = array($ticket_no,$username,$user_name,$user_gender,$user_age,$ticket_fare,$total_fare,$user_mob,$user_email);
                $sec_execute = pg_query_params($conn,$insert_into_sec,$sec_array);
            }
            else if($userType === 'employee')
            {
                $_SESSION['emp_username'] = $username;
                $insert_into_sec = "INSERT INTO tickets_emp VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10)";
                $sec_array = array($ticket_no,$username,$user_name,$user_gender,$user_age,$ticket_fare,$emp_conn,$total_fare,$user_mob,$user_email);
                $sec_execute = pg_query_params($conn,$insert_into_sec,$sec_array);
            }
            else if($userType === 'travel_agent')
            {
                $_SESSION['ta_username'] = $username;
                $insert_into_sec = "INSERT INTO tickets_ta (ticket_no, username, user_name, user_gender, user_age, ticket_fare, ta_comm, total_fare, user_mob, user_email) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";

                $sec_array = array($ticket_no, $username, $user_name, $user_gender, $user_age, $ticket_fare, $ta_comm, $total_fare, $user_mob, $user_email);
                $sec_execute = pg_query_params($conn, $insert_into_sec, $sec_array); 
            }
            if($sec_execute){
                $get_seat_no = "SELECT seat_allocated.seat_no from tickets, seat_allocated WHERE tickets.ticket_no = seat_allocated.ticket_no AND seat_allocated.doj = $1 and tickets.train_no = $2 and seat_allocated.coach_no = $3 AND tickets.status = 'Confirmed' ORDER BY seat_allocated.seat_no DESC LIMIT 1";
                $get_seat_execute = pg_query_params($conn, $get_seat_no,array($doj,$train_no,$coach_no));
                if($get_seat_execute){
                    if(pg_num_rows($get_seat_execute)==0){
                        $seat_no = 1;
                    }
                    else{
                        $seat_row = pg_fetch_assoc($get_seat_execute);
                        $seat_no = $seat_row['seat_no'];
                        if($seat_no == $total_seats){
                            $get_seat_can = "SELECT seat_allocated.seat_no FROM tickets, seat_allocated WHERE tickets.ticket_no = seat_allocated.ticket_no AND seat_allocated.doj = $1 and tickets.train_no = $2 and seat_allocated.coach_no = $3 AND tickets.status = 'Cancelled' AND seat_allocated.seat_no NOT IN (SELECT seat_allocated.seat_no from tickets, seat_allocated WHERE tickets.ticket_no = seat_allocated.ticket_no AND seat_allocated.doj = $1 and tickets.train_no = $2 and seat_allocated.coach_no = $3 AND tickets.status = 'Confirmed' ORDER BY seat_allocated.seat_no DESC) ORDER BY seat_allocated.seat_no DESC LIMIT 1";
                            $get_can_execute = pg_query_params($conn, $get_seat_can,array($doj,$train_no,$coach_no));
                            if($get_can_execute){
                                $seat_row = pg_fetch_assoc($get_can_execute);
                                $seat_no = $seat_row['seat_no'];
                            }else {
                                die("Error fetching counter: " . pg_last_error($conn));
                                session_destroy();
                                session_abort();
                                echo '<script>window.alert("Got some technical Failure 0 '.$seat_no.'!!!"); window.location.href="../index.html";</script>';
                            }
                        }else{
                            $seat_no = $seat_no + 1;
                        }
                        
                    }
                    $insert_into_sa = "INSERT INTO seat_allocated VALUES ($1,$2,$3,$4)";
                    $sa_array = array($ticket_no,$coach_no,$seat_no,$doj);
                    $sa_execute = pg_query_params($conn,$insert_into_sa,$sa_array);
                    if($sa_execute){
                        $payment_status = 'Successful';
                        if($userType === 'passenger')
                        {
                            $insert_into_payment = "INSERT INTO payment (ticket_no, status, total_fare, ticket_fare, upi_used) VALUES ($1,$2,$3,$4,$5)";
                            $payment_array = array($ticket_no,$payment_status,$total_fare,$ticket_fare,$upi);
                            $payment_execute = pg_query_params($conn,$insert_into_payment,$payment_array);
                        }
                        else if($userType === 'employee')
                        {
                            $insert_into_payment = "INSERT INTO payment (ticket_no, status, total_fare, ticket_fare, emp_conn, upi_used) VALUES ($1,$2,$3,$4,$5,$6)";
                            $payment_array = array($ticket_no,$payment_status,$total_fare,$ticket_fare,$emp_conn,$upi);
                            $payment_execute = pg_query_params($conn,$insert_into_payment,$payment_array);
                        }
                        else if($userType === 'travel_agent')
                        {
                            $insert_into_payment = "INSERT INTO payment (ticket_no, status, total_fare, ticket_fare, ta_comm, upi_used) VALUES ($1,$2,$3,$4,$5,$6)";
                            $payment_array = array($ticket_no,$payment_status,$total_fare,$ticket_fare,$ta_comm,$upi);
                            $payment_execute = pg_query_params($conn,$insert_into_payment,$payment_array);
                        }
                        if($payment_execute){
                            pg_query($conn,"COMMIT");
                        echo '<script>window.alert("Your Ticket has been Booked Successfully!!!");</script>';
                            
                            echo '<script>window.location.href="view_ticket.php";</script>';
                        }else{
                            pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
                            session_destroy();
                            session_abort();
                            echo '<script>window.alert("Got some technical Failure 1!!!"); window.location.href="../index.html";</script>';
                            echo "Error: " . pg_last_error($conn);
                        }

                    }
                    else{
                        pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
                        session_destroy();
                        session_abort();
                        echo '<script>window.alert("Got some technical Failure 2 '.pg_num_rows($get_seat_execute).'!!!"); window.location.href="../index.html";</script>';
                        echo "Error:" . pg_last_error($conn);
                    }
                }
            }else{
                pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
                session_destroy();
                session_abort();
                echo '<script>window.alert("Got some technical Failure 3!!!"); window.location.href="../index.html";</script>';

                echo "Error: " . pg_last_error($conn);
            }
        } else {
            pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
            session_destroy();
            session_abort();
            echo '<script>window.alert("Got some technical Failure 4!!!"); window.location.href="../index.html";</script>';
            echo "Error: " . pg_last_error($conn);
        }

    } else {
        die("Error fetching counter: " . pg_last_error($conn));
        session_destroy();
        session_abort();
        echo '<script>window.alert("Got some technical Failure 5!!!"); window.location.href="../index.html";</script>';
    }
?>