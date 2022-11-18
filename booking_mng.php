<?php
require_once "header.php";
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    die();
}

// find user's booking records
$query = $conn->prepare("select re.ID, l.scheduleID, r.point1, r.point2, l.isReturn,re.date, a.model, l.time, l.minutes,re.seat, l.price
from Receipt re
         left join Schedules l on l.scheduleID = re.scheduleID
         left join Aircraft a on a.craftID = l.aircraftID
         left join Routes r on r.routeID = l.routeID
where re.email=?");
$query->bind_param("s", $_SESSION['user'][0]);
$query->execute();
$schedules = $query->get_result()->fetch_all();
?>

<div class="white-container">
    <h2 class="text-center">Booking Management</h2>
    <div>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Booking ref#</th>
                <th>Flight No.</th>
                <th>FROM</th>
                <th>TO</th>
                <th>Departure Date</th>
                <th>Departure Time</th>
                <th>Duration</th>
                <th>Craft Model</th>
                <th>Ticket</th>
                <th>Price</th>
                <th width="200">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($schedules as $row) { ?>
                <tr>
                    <td><?= $row[0] ?></td>
                    <td><?= $row[1] ?></td>
                    <td><?= $row[$row[4] == 0 ? 2 : 3] ?></td>
                    <td><?= $row[$row[4] == 0 ? 3 : 2] ?></td>
                    <td><?= $row[5] ?></td>
                    <td><?= $row[7] ?></td>
                    <td><?= $row[8] ?> minutes</td>
                    <td><?= $row[6] ?> </td>
                    <td><?= $row[9] ?></td>
                    <td>$<?= $row[10] ?></td>
                    <td>
                        <a class="btn btn-primary" href="receipt.php?id=<?= $row[0] ?>">Receipt</a>
                        <a class="btn btn-danger" href="cancel.php?id=<?= $row[0] ?>">Cancel</a>
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
