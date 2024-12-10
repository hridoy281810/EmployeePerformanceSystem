<?php
require_once 'connection_db.php';
$employee_id = $_GET['employee_id'];
$stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();

header("Location: view_employees.php");
$conn->close();
?>
