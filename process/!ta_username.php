<?php
$query = "SELECT * FROM travel_agent WHERE username = $1;";
$ta_array = array($ta_username);
$result = pg_query_params($conn,$query,$ta_array);
if (pg_num_rows($result) == 0) {
    echo '<script>window.location.href="../travel_agent/index.html";</script>';
    exit();
}
?>
