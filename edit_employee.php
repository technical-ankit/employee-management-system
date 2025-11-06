<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role']=='employee')) { header("Location: login.php"); exit; }

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM employees WHERE id=$id");
$emp = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $name=$_POST['name']; $email=$_POST['email']; $position=$_POST['position'];
  $role_text=$_POST['role_text']; $salary=$_POST['salary']; $pending=$_POST['pending_salary'];
  $stmt=$conn->prepare("UPDATE employees SET name=?,email=?,position=?,role_text=?,salary=?,pending_salary=? WHERE id=?");
  $stmt->bind_param("ssssddi",$name,$email,$position,$role_text,$salary,$pending,$id);
  $stmt->execute();
  header("Location: employees.php");
  exit;
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Edit Employee</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container mt-4">
<h3>Edit Employee</h3>
<form method="post">
<input class="form-control mb-2" name="name" value="<?=htmlspecialchars($emp['name'])?>">
<input class="form-control mb-2" name="email" value="<?=htmlspecialchars($emp['email'])?>">
<input class="form-control mb-2" name="position" value="<?=htmlspecialchars($emp['position'])?>">
<input class="form-control mb-2" name="role_text" value="<?=htmlspecialchars($emp['role_text'])?>">
<input class="form-control mb-2" type="number" name="salary" value="<?=$emp['salary']?>">
<input class="form-control mb-3" type="number" name="pending_salary" value="<?=$emp['pending_salary']?>">
<button class="btn btn-primary">Save</button>
<a href="employees.php" class="btn btn-secondary">Cancel</a>
</form></div></body></html>
