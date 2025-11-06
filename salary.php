<?php
session_start(); include 'db.php';
if(!isset($_SESSION['user_id'])){header("Location: login.php");exit;}
$res=$conn->query("SELECT * FROM employees WHERE status='active'");
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Salary</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container mt-4">
<h3>Salary Overview</h3>
<table class="table table-bordered table-hover">
<thead><tr><th>ID</th><th>Name</th><th>Salary</th><th>Pending</th></tr></thead>
<tbody>
<?php while($row=$res->fetch_assoc()): ?>
<tr>
<td><?=$row['id']?></td><td><?=$row['name']?></td><td><?=$row['salary']?></td>
<td><?=$row['pending_salary']?></td>
</tr>
<?php endwhile;?>
</tbody></table>
<a href="dashboard.php" class="btn btn-secondary">Back</a>
</div></body></html>
