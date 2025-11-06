<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] == 'employee')) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = $_POST['name'];
  $email = $_POST['email'];
  $position = $_POST['position'];
  $role_text = $_POST['role_text'];
  $salary = $_POST['salary'];
  $pending = $_POST['pending_salary'];

  $stmt = $conn->prepare("INSERT INTO employees(name,email,position,role_text,salary,pending_salary,status) VALUES(?,?,?,?,?,?,'active')");
  $stmt->bind_param("ssssdd",$name,$email,$position,$role_text,$salary,$pending);
  if ($stmt->execute()) header("Location: employees.php");
  else $error="Failed: ".$conn->error;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"><title>Add Employee</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
<h3>Add Employee</h3>
<?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form method="post">
<input class="form-control mb-2" name="name" placeholder="Full name" required>
<input class="form-control mb-2" name="email" placeholder="Email" required>
<input class="form-control mb-2" name="position" placeholder="Position" required>
<input class="form-control mb-2" name="role_text" placeholder="Role/Department" required>
<input class="form-control mb-2" type="number" name="salary" placeholder="Salary" required>
<input class="form-control mb-3" type="number" name="pending_salary" placeholder="Pending Salary" required>
<button class="btn btn-success">Add Employee</button>
<a href="employees.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</body></html>
