<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];

// Force reload when ?reload=true is clicked
if (isset($_GET['reload'])) {
    header("Location: employees.php");
    exit;
}

// Fetch all active employees
$result = $conn->query("SELECT * FROM employees WHERE status='active'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employee List | Employee Management System</title>
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
    h3 {
      color: #333;
    }
    .container {
      margin-top: 30px;
    }
    .table th {
      background-color: #007bff;
      color: white;
      text-align: center;
    }
    .table td {
      text-align: center;
      vertical-align: middle;
    }
    .btn {
      border-radius: 5px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Employee Management System</a>
    <div class="d-flex">
      <a href="dashboard.php" class="btn btn-light btn-sm me-2">Dashboard</a>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Page Content -->
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Employee List</h3>

    <div>
      <a href="employees.php?reload=true" class="btn btn-info btn-sm me-2">↻ Reload List</a>
      <?php if ($role == 'admin' || $role == 'hr'): ?>
        <a href="add_employee.php" class="btn btn-success btn-sm">+ Add Employee</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover shadow-sm">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Position</th>
          <th>Role</th>
          <th>Salary (₹)</th>
          <th>Pending (₹)</th>
          <?php if ($role == 'admin' || $role == 'hr'): ?>
            <th>Actions</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['position']}</td>
                    <td>{$row['role_text']}</td>
                    <td>{$row['salary']}</td>
                    <td>{$row['pending_salary']}</td>";

            if ($role == 'admin' || $role == 'hr') {
              echo "<td>
                      <a href='edit_employee.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a> ";
              if ($role == 'admin') {
                echo "<a href='delete_employee.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this employee?\")'>Delete</a>";
              }
              echo "</td>";
            }
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='8' class='text-center text-muted'>No employees found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<footer class="text-center mt-5 mb-3 text-muted">
  © 2025 Employee Management System | Developed by Ankit
</footer>

</body>
</html>
