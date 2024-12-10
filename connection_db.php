<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'employee_new_db';

// Database Connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
