<?php
session_start();
include 'db.php';
if ($_SESSION['role']!='admin') { header("Location: employees.php"); exit; }
$id = intval($_GET['id']);
$conn->query("UPDATE employees SET status='deleted' WHERE id=$id");
header("Location: employees.php");
