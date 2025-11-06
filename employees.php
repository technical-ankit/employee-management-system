<?php
session_start();
include 'db.php';

// If user not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user info
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$user_query = $conn->query("SELECT name FROM users WHERE id='$user_id'");
$user = $user_query->fetch_assoc();
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
      max-width: 1100px;
      margin: 40px auto;
    }
    .card {
      transition: 0.3s;
      border-radius: 12px;
    }
    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h3 {
      color: #333;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Employee Management System</a>
      <div class="d-flex">
        <span class="text-white me-3">Hi, <?= htmlspecialchars($username) ?> (<?= ucfirst($role) ?>)</span>
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Dashboard -->
  <div class="dashboard-container">
    <h3 class="mb-4">Dashboard</h3>
    <div class="row g-4">

      <?php if ($role == 'admin' || $role == 'hr'): ?>
        <!-- Add Employee -->
        <div class="col-md-4">
          <a href="add_employee.php" class="text-decoration-none text-dark">
            <div class="card shadow-sm p-3 border-primary border-2">
              <div class="card-body text-center">
                <h5>Add Employee</h5>
                <p class="text-muted mb-0">Add new employee details</p>
              </div>
            </div>
          </a>
        </div>
      <?php endif; ?>

      <!-- View Employees -->
      <div class="col-md-4">
        <a href="employees.php" class="text-decoration-none text-dark">
          <div class="card shadow-sm p-3 border-success border-2">
            <div class="card-body text-center">
              <h5>Employee List</h5>
              <p class="text-muted mb-0">View all employees</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Salary -->
      <div class="col-md-4">
        <a href="salary.php" class="text-decoration-none text-dark">
          <div class="card shadow-sm p-3 border-warning border-2">
            <div class="card-body text-center">
              <h5>Salary Management</h5>
              <p class="text-muted mb-0">View and manage salaries</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Attendance 
      <div class="col-md-4">
        <a href="attendance.php" class="text-decoration-none text-dark">
          <div class="card shadow-sm p-3 border-info border-2">
            <div class="card-body text-center">
              <h5>Attendance</h5>
              <p class="text-muted mb-0">View attendance records</p>
            </div>
          </div>
        </a>
      </div>-->

      <!-- Leave Management 
      <div class="col-md-4">
        <a href="leaves.php" class="text-decoration-none text-dark">
          <div class="card shadow-sm p-3 border-danger border-2">
            <div class="card-body text-center">
              <h5>Leave Management</h5>
              <p class="text-muted mb-0">Apply or approve leaves</p>
            </div>
          </div>
        </a>
      </div>-->

      <?php if ($role == 'admin'): ?>
        <!-- Deleted Employees -->
        <div class="col-md-4">
          <a href="deleted.php" class="text-decoration-none text-dark">
            <div class="card shadow-sm p-3 border-dark border-2">
              <div class="card-body text-center">
                <h5>Deleted Employees</h5>
                <p class="text-muted mb-0">View soft-deleted records</p>
              </div>
            </div>
          </a>
        </div>
      <?php endif; ?>

    </div>
  </div>

  <footer class="text-center mt-5 mb-3 text-muted">
    © 2025 Employee Management System | Developed by Ankit
  </footer>
</body>
</html>
