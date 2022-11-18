<?php
// is user not login, redirect to login page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    die();
}

require_once "header.php";

// sanitize user input
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

// get start week day
$start = new DateTime($_POST['start']);
$startWd = intval($start->format('w'));

// find from airport
$query = $conn->prepare("SELECT * FROM Destinations where code=?");
$query->bind_param('s', $_POST['departure']);
$query->execute();
$from = $query->get_result()->fetch_array(MYSQLI_NUM);

// find to airport
$query = $conn->prepare("SELECT * FROM Destinations where code=?");
$query->bind_param('s', $_POST['arrival']);
$query->execute();
$to = $query->get_result()->fetch_array(MYSQLI_NUM);

// find schedule
$query = $conn->prepare("select l.scheduleID, d.airport, d2.airport, l.isReturn, a.model, l.time,
       l.minutes, l.price, sw.weekDay, a.capacity
from ScheduleWeekdays sw
        left join Schedules l on l.scheduleID = sw.scheduleID
         left join Aircraft a on a.craftID = l.aircraftID
         left join Routes r on r.routeID = l.routeID
         left join Destinations d on r.point1 = d.code
         left join Destinations d2 on r.point2 = d2.code
where (d.code = ? and d2.code = ? and l.isReturn = 0)
   or (d2.code = ? and d.code = ? and l.isReturn = 1)
");

$query->bind_param('ssss', $_POST['departure'], $_POST['arrival'], $_POST['departure'], $_POST['arrival']);
$query->execute();
$schedules = $query->get_result()->fetch_all();

$dates = array();
$seats = array();
// find schedule date and available seats
foreach ($schedules as $s) {
    $wd = intval($s[8]);
    if ($startWd == $wd) {
        $date = new DateTime($_POST['start']);
    } else if ($wd > $startWd) {
        $diff = $wd - $startWd;
        $date = new DateTime($_POST['start']);
        while ($diff > 0) {
            $date->add(new DateInterval('P1D'));
            $diff--;
        }
    } else {
        $temp = $startWd;
        $date = new DateTime($_POST['start']);
        while ($temp < 7) {
            $date->add(new DateInterval('P1D'));
            $temp++;
        }
        $diff = $wd;
        while ($diff > 0) {
            $date->add(new DateInterval('P1D'));
            $diff--;
        }
    }
    $datestr = $date->format('Y-m-d');
    array_push($dates, $datestr);

    $query = $conn->prepare('select sum(seat) from Receipt where date=? and scheduleID=?');
    $query->bind_param('ss', $datestr, $s[0]);
    $query->execute();
    $seat = $query->get_result()->fetch_all();

    //    var_dump($seat);
    array_push($seats, $s[9] - intval($seat[0][0]));
}

?>
<div class="white-container">
    <h2 class="text-center"><?= $from[2] ?> --TO-- <?= $to[2] ?></h2>
    <div>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Fly No.</th>
                <th>Date</th>
                <th>Departure Time</th>
                <th>Duration</th>
                <th>Craft Model</th>
                <th>Available Seats</th>
                <th>Price</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($schedules as $index => $row) { ?>
                <tr>
                    <td><?= $row[0] ?></td>
                    <td><?= $dates[$index] ?></td>
                    <td><?= $row[5] ?></td>
                    <td><?= $row[6] ?> minutes</td>
                    <td><?= $row[4] ?></td>
                    <td><?= $seats[$index] ?></td>
                    <td>$<?= $row[7] ?></td>
                    <td>
                        <a class="btn btn-primary"
                           href="doBook.php?scheduleID=<?= $row[0] ?>&date=<?= $dates[$index] ?>">Book</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php
require_once "footer.php"
?>
