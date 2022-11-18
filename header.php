<?php
include_once "database.php";
session_start();

// prepare weekday names
$weekdays_names = array();
array_push($weekdays_names, 'Sun.');
array_push($weekdays_names, 'Mon.');
array_push($weekdays_names, 'Tue.');
array_push($weekdays_names, 'Wed.');
array_push($weekdays_names, 'Thr.');
array_push($weekdays_names, 'Fri.');
array_push($weekdays_names, 'Sat.');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<img class="bg" alt="bg" src="image/pexels-marina-hinic-730778.jpg">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Airline Booking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex flex-grow-1"></div>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <?php
                if (isset($_SESSION['user'])) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="booking_mng.php">Bookings Management</a>
                    </li>
                    <li class="navbar-text">
                        Welcome <?= $_SESSION['user'][1] ?>,
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li><a class="nav-link" href="login.php">Login</a></li>
                    <li><a class="nav-link" href="signup.php">Signup</a></li>
                <?php }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
