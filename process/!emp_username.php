<?php
$query = "SELECT * FROM employee WHERE username = $1;";
$emp_array = array($emp_username);
$result = pg_query_params($conn,$query,$emp_array);
if (pg_num_rows($result) == 0) {
    echo '<script>window.location.href="../employee/index.html";</script>';
    exit();
}
?>
