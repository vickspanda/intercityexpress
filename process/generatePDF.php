<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$get_back = FALSE;
$more = 'FALSE';
$title = $_SESSION['title'] ?? '';
$username = '';
$userType = '';
$ticket_no = '';

if (isset($_SESSION['pass_username'])) {
    $username = $_SESSION['pass_username'];
    $userType = $_POST["userType"] ?? '';
    $ticket_no = $_POST["ticket_no"] ?? '';
}
if (isset($_SESSION['emp_username'])) {
    $username = $_SESSION['emp_username'];
    $userType = $_POST["userType"] ?? '';
    $ticket_no = $_POST["ticket_no"] ?? '';
}
if (isset($_SESSION['ta_username'])) {
    $username = $_SESSION['ta_username'];
    $userType = $_POST["userType"] ?? '';
    $ticket_no = $_POST["ticket_no"] ?? '';
}
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
if (!$username) {
    echo '<script>window.location.href="../index.html";</script>';
    exit;
}

include '../process/connect.php';

if (isset($_SESSION['ticket_no'])) {
    $ticket_no = $_SESSION['ticket_no'];
    $userType = $_SESSION["userType"] ?? '';
}
if ($userType === 'passenger') {
    $user = 'passenger';
    $userTicket = 'tickets_pass';
} elseif ($userType === 'employee') {
    $user = 'emp';
    $userTicket = 'tickets_emp';
} elseif ($userType === 'travel_agent') {
    $user = 'ta';
    $userTicket = 'tickets_ta';
}
if (isset($_SESSION['get_back'])) {
    $get_back = $_SESSION['get_back'];
}

$get_ticket_info = "SELECT tickets.train_no, tickets.status, trains.train_name, tickets.board_stn, tickets.drop_stn, tickets.starts_on, tickets.ends_on, seat_allocated.coach_no, seat_allocated.seat_no, seats.seat_type, $userTicket.username, $userTicket.user_name, $userTicket.user_age, $userTicket.user_gender, $userTicket.user_mob, $userTicket.user_email, payment.status as payment_status, payment.upi_used, payment.ticket_fare, payment.total_fare, payment.emp_conn, payment.ta_comm FROM tickets, $userTicket, payment, seat_allocated, seats, trains WHERE tickets.ticket_no = $userTicket.ticket_no AND tickets.ticket_no = payment.ticket_no AND tickets.ticket_no = seat_allocated.ticket_no AND tickets.train_no = trains.train_no AND seat_allocated.seat_no = seats.seat_no AND tickets.ticket_no = $1";
$get_ticket_execute = pg_query_params($conn, $get_ticket_info, array($ticket_no));
if (!$get_ticket_execute) {
    echo "Error: " . pg_last_error($conn);
    exit;
} else {
    $ticket_row = pg_fetch_assoc($get_ticket_execute);
    $train_no = $ticket_row['train_no'];
    $train_name = $ticket_row['train_name'];
    $status = $ticket_row['status'];
    $dep_time = $ticket_row['starts_on'];
    $arr_time = $ticket_row['ends_on'];
    $coach_no = $ticket_row['coach_no'];
    $seat_no = $ticket_row['seat_no'];
    $seat_type = $ticket_row['seat_type'];
    $username = $ticket_row['username'];
    $user_name = $ticket_row['user_name'];
    $user_age = $ticket_row['user_age'];
    $user_gender = $ticket_row['user_gender'];
    $payment_status = $ticket_row['payment_status'];
    $upi = $ticket_row['upi_used'];
    $total_fare = $ticket_row['total_fare'];
    $ticket_fare = $ticket_row['ticket_fare'];
    $ta_comm = $ticket_row['ta_comm'];
    $emp_conn = $ticket_row['emp_conn'];
    $start = $ticket_row['board_stn'];
    $end = $ticket_row['drop_stn'];
    $user_email = $ticket_row['user_email'];
    $user_mob = $ticket_row['user_mob'];
}

if($coach_no === "A1"){
    $coach = "AC Chair Car";
}else if($coach_no === "D1"){
    $coach = "2S Sitting Car";
}

$get_station_name = "SELECT station_name FROM stations WHERE station_code = $1";
$get_start = pg_query_params($conn, $get_station_name, array($start));
$start_row = pg_fetch_assoc($get_start);
$from_station = $start_row['station_name'];

$get_end = pg_query_params($conn, $get_station_name, array($end));
$end_row = pg_fetch_assoc($get_end);
$to_station = $end_row['station_name'];

$ticket_info = [
    "Ticket No." => $ticket_no,
    "Ticket Status" => $status,
    "Train No." => $train_no,
    "Train Name" => $train_name,
    "Boarding Station" => $from_station,
    "Drop Station" => $to_station,
    "Starts on" => $dep_time,
    "Ends on" => $arr_time,
    "Coach No." => $coach,
    "Seat No." => "$coach_no/$seat_no",
    "Seat Type" => $seat_type,
    "Username" => $username,
    "Traveler's Name" => $user_name,
    "Traveler's Age" => $user_age,
    "Gender" => $user_gender,
    "Email" => $user_email,
    "Mobile Number" => $user_mob,
    "Payment Status" => $payment_status,
    "UPI ID Used" => $upi,
    "Ticket Fare" => $ticket_fare,
    "Total Fare" => $total_fare
];

if ($userType === 'travel_agent') {
    $ticket_info["Agent's Commission"] = $ta_comm;
} else if ($userType === 'employee') {
    $ticket_info["Employee's Concession"] = $emp_conn;
}

// Convert ticket info to JSON
$ticket_info_json = json_encode($ticket_info);

// Call the Flask API to generate the PDF
$ch = curl_init('http://localhost:5000/generate_ticket');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_info_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
if ($response === FALSE) {
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    exit;
}
curl_close($ch);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="train_ticket.pdf"');
echo $response;
?>
