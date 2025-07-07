<?php
session_start();
require_once '../-TRX-PHP-Finals/config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<?php include '../-TRX-PHP-FINALS/includes/header.php'; ?>

<div class="wallpaper" style="background-image: url('assets/img/library2.jpg');"></div>

<div class="login-card">
    <h2>Login</h2>
    <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <label>Username: <input type="text" name="username" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <button type="submit">Login</button>
    </form>
    <a href="register.php">Register as Student</a>
</div>

<?php include '../-TRX-PHP-FINALS/includes/footer.php'; ?>
