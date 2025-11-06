<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, email, password, role, name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["name"] = $user["name"];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "❌ Wrong password!";
        }
    } else {
        $error = "❌ No account found with that email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | EMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card p-4 mx-auto" style="max-width: 400px;">
    <h3 class="text-center text-primary mb-3">Employee Management System</h3>

    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <div class="text-center text-muted mt-3" style="font-size:14px;">
      <b>Admin:</b> admin@ems.com / 123<br>
      <b>HR:</b> hr@ems.com / 123<br>
      <b>Employee:</b> emp@ems.com / 123
    </div>
  </div>
</div>
</body>
</html>
