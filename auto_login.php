<?php
// auto_login.php  — DEV ONLY
session_start();
include 'db.php';

// Allow only local requests
$allowed_hosts = ['127.0.0.1', '::1', 'localhost'];
$remote = $_SERVER['REMOTE_ADDR'] ?? '';
if (!in_array($remote, $allowed_hosts)) {
    http_response_code(403);
    echo "Not allowed";
    exit;
}

// secret key in URL so it's not accidentally clickable
$secret = 'devquicklogin'; // CHANGE to anything you prefer
if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    echo "Missing or wrong key. Use ?key=devquicklogin&role=admin";
    exit;
}

// map roles to emails (must exist in users table)
$role = $_GET['role'] ?? 'admin';
$map = [
  'admin' => 'admin@ems.com',
  'hr' => 'hr@ems.com',
  'employee' => 'emp@ems.com'
];
if (!isset($map[$role])) {
    echo "Unknown role";
    exit;
}

$email = $map[$role];

// fetch user by email
$stmt = $conn->prepare("SELECT id, role, name FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo "User not found: $email";
    exit;
}
$user = $res->fetch_assoc();

// set session exactly like login would
$_SESSION['user_id'] = $user['id'];
$_SESSION['role']    = $user['role'];
$_SESSION['name']    = $user['name'];

// redirect to dashboard
header("Location: dashboard.php");
exit;
