<?php
require_once "header.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // find user by email and password
    $query = $conn->prepare("SELECT * FROM Users where email=? and password=?");
    $query->bind_param('ss', $_POST['email'], $_POST['password']);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_array(MYSQLI_NUM);

    if ($user) {
        // matched, do login
        $_SESSION['user'] = $user;
        header("Location: index.php");
        die();
    } else {
        // not matched
        $error = 'email or password invalid';
    }
}
?>
<form method="post" action="login.php" class="white-container">
    <h1>Login</h1>
    <div>
        <label for="email">Email</label>
        <input name="email" type="email" id="email" required class="form-control"/>
    </div>
    <div>
        <label for="password">Password</label>
        <input name="password" id="password" placeholder="Enter password"
               type="password" required class="form-control"/>
    </div>
    <p class="text-danger"><?= $error ?></p>
    <div>
        <button class="btn btn-primary">Login</button>
    </div>
</form>
<?php
require_once "footer.php"
?>

