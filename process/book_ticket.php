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
    if(!$username){
        echo "<script>window.location.href='../index.html'</script>";
    }
    include 'connect.php';
    include 'connect.php';

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
            if($userType === 'passenger')
            {
                $user = 'passenger';
                $_SESSION['pass_username'] = $username;
                $insert_into_sec = "INSERT INTO tickets_pass VALUES ($1,$2,$3,$4,$5,$6,$7)";
                $sec_array = array($ticket_no,$username,$user_name,$user_gender,$user_age,$ticket_fare,$total_fare);
                $sec_execute = pg_query_params($conn,$insert_into_sec,$sec_array);
            }
            else if($userType === 'employee')
            {
                $user = 'emp';
                $_SESSION['emp_username'] = $username;
                $insert_into_sec = "INSERT INTO tickets_emp VALUES ($1,$2,$3,$4,$5,$6,$7,$8)";
                $sec_array = array($ticket_no,$username,$user_name,$user_gender,$user_age,$ticket_fare,$emp_conn,$total_fare);
                $sec_execute = pg_query_params($conn,$insert_into_sec,$sec_array);
            }
            else if($userType === 'travel_agent')
            {
                $user = 'ta';
                $_SESSION['ta_username'] = $username;
                $insert_into_sec = "INSERT INTO tickets_ta VALUES ($1,$2,$3,$4,$5,$6,$7,$8)";
                
                $sec_array = array($ticket_no,$username,$user_name,$user_gender,$user_age,$ticket_fare,$ta_comm,$total_fare);
                $sec_execute = pg_query_params($conn,$insert_into_sec,$sec_array);
            }
            if($sec_execute){
                $get_seat_no = "SELECT seat_no from tickets, seat_allocated WHERE tickets.ticket_no = seat_allocated.ticket_no AND seat_allocated.doj = $1 and tickets.train_no = $2 and seat_allocated.coach_no = $3 AND tickets.status = 'Confirmed' ORDER BY seat_no DESC LIMIT 1";
                $get_seat_execute = pg_query_params($conn, $get_seat_no,array($doj,$train_no,$coach_no));
                if($get_seat_execute){
                    if(pg_num_rows($get_seat_execute)==0){
                        $seat_no = 1;
                    }else{
                        $seat_row = pg_fetch_assoc($get_seat_execute);
                        $seat_no = $seat_row['seat_no'] + 1;
                    }
                    $insert_into_sa = "INSERT INTO seat_allocated VALUES ($1,$2,$3,$4)";
                    $sa_array = array($ticket_no,$coach_no,$seat_no,$doj);
                    $sa_execute = pg_query_params($conn,$insert_into_sa,$sa_array);
                    if($sa_execute){
                        pg_query($conn,"COMMIT");
                        echo '<script>window.alert("Ticket has been Booked Successfully with Ticket No. = '.$ticket_no.'!!!"); window.location.href="../'.$userType.'/'.$user.'_dashboard.php";</script>';

                    }
                    else{
                        pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
                        session_destroy();
                        session_abort();
                        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="../index.html";</script>';
                        echo "Error: 3 " . pg_last_error($conn);
                    }
                }
            }else{
                pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
                session_destroy();
                session_abort();
                echo "Error: 2" . pg_last_error($conn);
            }
        } else {
            pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
            session_destroy();
            session_abort();
            echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="../index.html";</script>';
            echo "Error: 1" . pg_last_error($conn);
        }

    } else {
        die("Error fetching counter: " . pg_last_error($conn));
        echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="../index.html";</script>';
    }
?>