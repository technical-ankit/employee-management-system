<?php
session_start(); include 'db.php';
if($_SESSION['role']!='admin'){header("Location: dashboard.php");exit;}
$deleted=$conn->query("SELECT * FROM employees WHERE status='deleted'");
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Deleted Employees</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container mt-4">
<h3>Deleted Employees</h3>
<table class="table table-bordered"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Position</th><th>Status</th></tr></thead>
<tbody>
<?php while($r=$deleted->fetch_assoc()): ?>
<tr><td><?=$r['id']?></td><td><?=$r['name']?></td><td><?=$r['email']?></td><td><?=$r['position']?></td><td><?=$r['status']?></td></tr>
<?php endwhile;?>
</tbody></table>
<a href="dashboard.php" class="btn btn-secondary">Back</a>
</div></body></html>
