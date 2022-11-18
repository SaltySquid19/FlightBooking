<?php
require_once "header.php";

// find all destinations
$query = $conn->prepare("select * from Destinations");
$query->execute();
$des = $query->get_result()->fetch_all();


?>

<form method="post" action="booking.php" class="white-container">
    <div class="row">
        <div class="col-4">
            <label>Departure</label>
            <select name="departure" class="form-control" required>
                <?php foreach ($des as $key => $v) { ?>
                    <option value="<?= $v[0] ?>" <?= $v[0] == 'NZNE' ? 'selected' : '' ?>><?= $v[2] ?> (<?= $v[3] ?>)
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4">
            <label>Arrival</label>
            <select name="arrival" class="form-control" required>
                <?php foreach ($des as $key => $v) { ?>
                    <option value="<?= $v[0] ?>"><?= $v[2] ?> (<?= $v[3] ?>)</option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4">
            <label>Seats</label>
            <select name="seat" class="form-control" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
            <br/>
        </div>
        <div class="col-4">
            <label>Start date</label>
            <input type="date" name="start" required class="form-control"/>
        </div>
        <div class="col-4">
            <label>End date</label>
            <div>within a week</div>
        </div>
        <div class="col-4">
            <button class="btn btn-primary mt-3">Search</button>
        </div>
    </div>
</form>

<?php
require_once "footer.php"
?>
