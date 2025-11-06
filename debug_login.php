<?php
// debug_login.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';         // must be the same db.php your app uses

echo "<h3>DB connection test</h3>";
if ($conn) echo "<p style='color:green'>Connected to DB: " . htmlspecialchars($conn->query("SELECT DATABASE()")->fetch_row()[0]) . "</p>";
else { echo "<p style='color:red'>No DB connection</p>"; exit; }

// Show users table rows (safe display)
echo "<h3>Users table (first 10 rows)</h3>";
$res = $conn->query("SELECT id,email,role,password,name FROM users LIMIT 10");
if (!$res) { echo "<pre>Query failed: ".$conn->error."</pre>"; exit; }
echo "<table border='1' cellpadding='6'><tr><th>id</th><th>email</th><th>role</th><th>password_hash</th><th>name</th></tr>";
while($r = $res->fetch_assoc()){
    echo "<tr>";
    echo "<td>".htmlspecialchars($r['id'])."</td>";
    echo "<td>".htmlspecialchars($r['email'])."</td>";
    echo "<td>".htmlspecialchars($r['role'])."</td>";
    echo "<td style='max-width:600px;word-break:break-all;'>".htmlspecialchars($r['password'])."</td>";
    echo "<td>".htmlspecialchars($r['name'])."</td>";
    echo "</tr>";
}
echo "</table>";

// Now test password_verify for an account you try to login with.
// Change $test_email and $test_password to the one you're testing.
$test_email = 'admin@ems.com';
$test_password = '123'; // the password you are entering in login form

echo "<h3>Testing login for: ".htmlspecialchars($test_email)."</h3>";
$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $test_email);
$stmt->execute();
$res2 = $stmt->get_result();

if ($res2->num_rows === 0) {
    echo "<p style='color:red'>No user with that email found.</p>";
    exit;
}
$row = $res2->fetch_assoc();
$hash = $row['password'];
echo "<p>Stored hash: <code>".htmlspecialchars($hash)."</code></p>";
echo "<p>Testing password_verify('".htmlspecialchars($test_password)."', stored_hash) ...</p>";
if (password_verify($test_password, $hash)) {
    echo "<p style='color:green'>password_verify → TRUE (match)</p>";
} else {
    echo "<p style='color:red'>password_verify → FALSE (no match)</p>";
    // extra: show password_hash of test_password for comparison
    echo "<p>Hash of test password if freshly created here: <code>".password_hash($test_password, PASSWORD_DEFAULT)."</code></p>";
}

// show PHP version and password functions availability
echo "<h3>Environment</h3>";
echo "<p>PHP version: ".phpversion()."</p>";
echo "<p>password_hash exists? ".(function_exists('password_hash') ? 'yes' : 'no')."</p>";
echo "<p>password_verify exists? ".(function_exists('password_verify') ? 'yes' : 'no')."</p>";
?>
