<?php
require_once "header.php";
// is user not login, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    die();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // find book airline capacity and booked number
    $date = new DateTime($_POST['date']);

    $query = $conn->prepare("select (SELECT capacity FROM Aircraft where craftID=?) as a, (SELECT sum(seat) as count FROM Receipt where scheduleID=? and date=?) as b");
    $query->bind_param('sss', $_POST['craftID'], $_POST['scheduleID'], $_POST['date']);
    $query->execute();
    $res = $query->get_result()->fetch_all()[0];
    $cap = $res[0];
    $booked = $res[1];

    if ($booked + intval($_POST['seat']) > $cap) {
        // booked out
        $error = 'no enough seat!';
    } else {
        // insert booking record
        $query = $conn->prepare("insert into Receipt (email, scheduleID, date, seat) VALUE (?,?,?,?)");
        $query->bind_param("ssss", $_SESSION['user'][0], $_POST['scheduleID'], $_POST['date'], $_POST['seat']);
        $query->execute();
        header('Location: receipt.php?id=' . $query->insert_id);
        die();
    }


}

//  find schedule by id
$query = $conn->prepare("SELECT * FROM Schedules where scheduleID=?");
$query->bind_param('s', $_GET['scheduleID']);
$query->execute();
$line = $query->get_result()->fetch_all()[0];
?>


<form action="doBook.php?scheduleID=<?= $_GET['scheduleID'] ?>&date=<?= $_GET['date'] ?>" method="post"
      class="white-container">
    <h1 class="text-center">Book Line <?= $line[0] ?> on <?= $_GET['date'] ?></h1>
    <input type="hidden" name="scheduleID" value="<?= $line[0] ?>">
    <input type="hidden" name="date" value="<?= $_GET['date'] ?>">
    <input type="hidden" name="craftID" value="<?= $line[1] ?>">
    <div>
        <label>Seat</label>
        <input type="number" min="1" step="1" required name="seat" class="form-control">
    </div>
    <div class="text-danger"><?= $error ?></div>
    <div class="mt-3">
        <button class="btn btn-primary">BOOK!</button>
    </div>
</form>

<?php
require_once "footer.php"
?>
