<?php
session_start();
require_once '../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    if ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Username already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, phone, username, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$first_name, $last_name, $email, $phone, $username, $hash, 'student']);
            header('Location: login.php');
            exit;
        }
    }
}
?>
<?php include '../includes/header.php'; ?>
<h2>Register as Student</h2>
<?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
<form method="post">
    <label>First Name: <input type="text" name="first_name" required></label>
    <label>Last Name: <input type="text" name="last_name" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <label>Phone: <input type="text" name="phone" required></label>
    <label>Username: <input type="text" name="username" required></label>
    <label>Password: <input type="password" name="password" required></label>
    <label>Confirm Password: <input type="password" name="confirm" required></label>
    <button type="submit">Register</button>
</form>
<a href="login.php">Back to Login</a>
<?php include '../includes/footer.php'; ?> 