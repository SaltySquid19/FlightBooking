<?php
require_once "header.php";

// cancel booking by id
$query = $conn->prepare("delete from Receipt where ID=?");
$query->bind_param("s", $_GET['id']);
$query->execute();
header('Location: booking_mng.php');
die();
