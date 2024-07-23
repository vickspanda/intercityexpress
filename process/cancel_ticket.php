<?php
    include 'connect.php';

    if (isset($_POST['ticket_no'])) {
        $ticket_no = $_POST['ticket_no'];
    }

    $status2 = 'Refunded';
    $status1 = 'Cancelled';

    $cancel_ticket = "UPDATE tickets SET status = $1 WHERE ticket_no = $2;";
    $update_payment = "UPDATE payment SET status = $1 WHERE ticket_no = $2;";

    $cancel_execute = pg_query_params($conn, $cancel_ticket, array($status1,$ticket_no));
    $cancel_execute = pg_query_params($conn, $update_payment, array($status2,$ticket_no));

    echo "<script>window.location.href='list_tickets.php'</script>";

    pg_close($conn);
?>
