<?php
require_once "header.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // insert user
    $query = $conn->prepare("insert into Users (email, name, password) VALUE (?,?,?)");
    $query->bind_param("sss", $_POST['email'], $_POST['name'], $_POST['password']);
    $res = $query->execute();
    if (!$res) {
        // insert failed
        $error = $query->error;
    } else {
        // insert success, find user
        $query = $conn->prepare("SELECT * FROM Users where email=?");
        $query->bind_param('s', $_POST['email']);
        $query->execute();
        // login
        $_SESSION['user'] = $query->get_result()->fetch_all()[0];
        header("Location: index.php");
        die();
    }
}

?>
<form method="post" action="signup.php" class="white-container">
    <h1>Signup</h1>
    <div>
        <label>Email</label>
        <input name="email" type="email" required class="form-control">
    </div>
    <div>
        <label>Name</label>
        <input class="form-control" name="name" required>
    </div>

    <div>
        <label>Password</label>
        <input class="form-control" name="password" type="password" required>
    </div>
    <p class="text-danger"><?= $error ?></p>
    <div>
        <button class="btn btn-primary">Signup</button>
    </div>
</form>
<?php
require_once "footer.php"
?>
