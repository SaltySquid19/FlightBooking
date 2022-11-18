<?php
require_once "header.php";
// is user not login, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    die();
}

$query = $conn->prepare("select re.ID, l.scheduleID, r.point1, r.point2, l.isReturn,re.date, a.model, l.time, l.minutes,re.seat, l.price
from Receipt re
         left join Schedules l on l.scheduleID = re.scheduleID
         left join Aircraft a on a.craftID = l.aircraftID
         left join Routes r on r.routeID = l.routeID
where re.ID=?");
$query->bind_param("s", $_GET['id']);
$query->execute();
$receipt = $query->get_result()->fetch_all()[0];
?>

<div class="white-container">
    <h2 class="text-center">Your Receipt</h2>
    <div>
        <p>Booking ref#: <?= $receipt[0] ?></p>
        <p>Flight No.: <?= $receipt[1] ?></p>
        <p>FROM: <?= $receipt[$receipt[4] == 0 ? 2 : 3] ?></p>
        <p>TO: <?= $receipt[$receipt[4] == 0 ? 3 : 2] ?></p>
        <p>Departure Date: <?= $receipt[5] ?> </p>
        <p>Departure Time: <?= $receipt[7] ?></p>
        <p>Duration: <?= $receipt[8] ?> minutes</p>
        <p>Craft Model: <?= $receipt[6] ?></p>
        <p>Ticket: <?= $receipt[9] ?></p>
        <p>Price: <?= $receipt[10] ?></p>
        <p>
            <a href="booking_mng.php" class="btn btn-primary">Go to bookings management</a>
            <a href="cancel.php?id=<?= $receipt[0] ?>" class="btn btn-danger">Cancel</a>
        </p>
    </div>
</div>

<?php
require_once "footer.php"
?>
