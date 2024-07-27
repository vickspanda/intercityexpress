<?php
include 'connect.php';

$from_station = $_POST['from_station'] ?? '';
$to_station = $_POST['to_station'] ?? '';

if(!$from_station || !$to_station){
    echo '<script>window.location.href="../process/schedule.html";</script>';
    exit();
}

$stnCode_query = "SELECT station_code FROM stations WHERE station_name = $1";
$from_stnCode = pg_query_params($conn, $stnCode_query, array($from_station));
$startStn = '';
$endStn = '';
$count = 0;

if ($from_stnCode && pg_num_rows($from_stnCode) > 0) {
    $from = pg_fetch_assoc($from_stnCode);
    $startStn = $from['station_code'];

    $to_stnCode = pg_query_params($conn, $stnCode_query, array($to_station));
    if ($to_stnCode && pg_num_rows($to_stnCode) > 0) {
        $to = pg_fetch_assoc($to_stnCode);
        $endStn = $to['station_code'];

        $_SESSION['endStn'] = $endStn;
        $_SESSION['startStn'] = $startStn;

        $getroute = "SELECT route_code, time_taken FROM routes WHERE start_station = $1 AND end_station = $2";
        $route_execute = pg_query_params($conn, $getroute, array($startStn, $endStn));
        if ($route_execute && pg_num_rows($route_execute) > 0) {
            $result = pg_fetch_assoc($route_execute);
            $route_code = $result['route_code'];
            $time_taken = $result['time_taken'];
            $xyz = 'Active';

            $get_train = "SELECT trains.train_no, trains.train_name FROM trains, train_schedule WHERE trains.route_code = $1 AND trains.status = $2 AND trains.train_no = train_schedule.train_no ORDER BY train_no DESC LIMIT 5";
            $train_execute = pg_query_params($conn, $get_train, array($route_code, $xyz));
            $count = pg_num_rows($train_execute);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/train_search.css">
    <title>Search Results</title>
</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <br>
        <h2><?php echo htmlspecialchars($from_station); ?> to <?php echo htmlspecialchars($to_station); ?></h2>
        <div class="details">
            <table style="width:90%">
                <tr>
                    <th>Train No.</th>
                    <th style="width:500px">Train Name</th>
                    <th style="text-align:center; width:200px">Action</th>
                </tr>
                <?php 
                if ($count > 0) {
                    while ($train_info = pg_fetch_assoc($train_execute)) {
                        $train_no = htmlspecialchars($train_info['train_no']);
                        $train_name = htmlspecialchars($train_info['train_name']);                          
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($train_no); ?><br></td>
                        <td><?php echo htmlspecialchars($train_name); ?></td>
                        <td style="text-align:center">
                            <form action="view_schedule.php" method="POST">
                                <input name="train_no" value="<?php echo $train_no ?>" hidden>
                                <button type="submit" id="unblock">VIEW DETAILS</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
        <?php 
        if ($count == 0) {
        ?>
            <p class="no-user">
                No Train(s) Found for This Route!!!
            </p>
        <?php
        }
        ?>
        <br><br>
        <button onclick="location.href='../process/schedule.html'" type="button" id="signup1">Back</button><br><br>
    </div>
</body>
</html>

<?php
pg_close($conn);
?>
