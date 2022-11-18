<?php
//ini_set('session.save_path', 'session');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'airline';
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die($conn->connect_error);
}


