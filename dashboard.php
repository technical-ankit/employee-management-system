<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch user name
$query = $conn->prepare("SELECT name FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$user = $query->get_result()->fetch_assoc();
$username = $user['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Employee Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      background-color: #0d6efd;
    }
    .navbar-brand, .nav-link, .text-white {
      color: #fff !important;
    }
    .dashboard-container {
      max-width: 1200px;
      margin: 40px auto;
    }
    .card {
      transition: 0.3s;
      border-radius: 12px;
      border: 2px solid transparent;
    }
    .card:hover {
      transform: translateY(-3px);
      border-color: #0d6efd;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .card-body h5 {
      font-weight: 600;
      color: #0d6efd;
    }
    footer {
      margin-top: 50px;
      color: #6c757d;
      font-size: 14px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Employee Management System</a>
    <div class="d-flex align-items-center">
      <span class="text-white me-3">Welcome, <?= htmlspecialchars($username) ?> (<?= ucfirst($role) ?>)</span>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Dashboard Content -->
<div class="dashboard-container">
  <h3 class="mb-4 text-center text-primary">Dashboard</h3>
  <div class="row g-4">

    <!-- Add Employee (Admin + HR) -->
    <?php if ($role == 'admin' || $role == 'hr'): ?>
      <div class="col-md-4">
        <a href="add_employee.php" class="text-decoration-none">
          <div class="card shadow-sm p-3">
            <div class="card-body text-center">
              <h5>Add Employee</h5>
              <p class="text-muted mb-0">Register a new employee</p>
            </div>
          </div>
        </a>
      </div>
    <?php endif; ?>

    <!-- View Employees -->
    <div class="col-md-4">
      <a href="employees.php" class="text-decoration-none">
        <div class="card shadow-sm p-3">
          <div class="card-body text-center">
            <h5>Employee List</h5>
            <p class="text-muted mb-0">View all employees</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Salary Management -->
    <div class="col-md-4">
      <a href="salary.php" class="text-decoration-none">
        <div class="card shadow-sm p-3">
          <div class="card-body text-center">
            <h5>Salary Management</h5>
            <p class="text-muted mb-0">View and manage salaries</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Attendance 
    <div class="col-md-4">
      <a href="attendance.php" class="text-decoration-none">
        <div class="card shadow-sm p-3">
          <div class="card-body text-center">
            <h5>Attendance</h5>
            <p class="text-muted mb-0">Track employee attendance</p>
          </div>
        </div>
      </a>
    </div>

     Leave Management 
    <div class="col-md-4">
      <a href="leaves.php" class="text-decoration-none">
        <div class="card shadow-sm p-3">
          <div class="card-body text-center">
            <h5>Leave Management</h5>
            <p class="text-muted mb-0">Manage employee leave requests</p>
          </div>
        </div>
      </a>
    </div>-->

    <!-- Add User Account (Admin only) -->
    <?php if ($role == 'admin'): ?>
      <div class="col-md-4">
        <a href="add_user.php" class="text-decoration-none">
          <div class="card shadow-sm p-3">
            <div class="card-body text-center">
              <h5>Create User Account</h5>
              <p class="text-muted mb-0">Add new Admin, HR or Employee login</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Deleted Employees (Admin only) -->
      <div class="col-md-4">
        <a href="deleted.php" class="text-decoration-none">
          <div class="card shadow-sm p-3">
            <div class="card-body text-center">
              <h5>Deleted Employees</h5>
              <p class="text-muted mb-0">View and restore removed employees</p>
            </div>
          </div>
        </a>
      </div>
    <?php endif; ?>

  </div>
</div>

<footer class="text-center">
  © 2025 Employee Management System | Developed by Ankit
</footer>

</body>
</html>
