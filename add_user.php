<?php
session_start();
include 'db.php';

// Only admin can add new users
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-warning'>User already exists with this email!</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>✅ User account created successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>❌ Failed to create user. Try again.</div>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add User | Employee Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      max-width: 600px;
      margin-top: 50px;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    h3 {
      text-align: center;
      color: #0d6efd;
      font-weight: 600;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Employee Management System</a>
    <div class="d-flex">
      <a href="dashboard.php" class="btn btn-light btn-sm me-2">Dashboard</a>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
  <h3>Add New User Account</h3>
  <?= $message; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" placeholder="Enter email" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter password" required>
    </div>
    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-select" required>
        <option value="">Select Role</option>
        <option value="admin">Admin</option>
        <option value="hr">HR</option>
        <option value="employee">Employee</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Add User</button>
  </form>
</div>
</body>
</html>
