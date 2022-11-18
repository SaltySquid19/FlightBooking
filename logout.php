<?php
require_once "header.php";
// logout
$_SESSION['user'] = array();
session_destroy();
header('Location: login.php');
die();
