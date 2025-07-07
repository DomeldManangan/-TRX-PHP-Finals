<?php
session_start();
require_once '../-TRX-PHP-Finals/config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$stmt = $pdo->query('SELECT id, username, role FROM users');
$users = $stmt->fetchAll();
include '../-TRX-PHP-Finals/includes/header.php';
?>
<main>
    <h2 style="color: #333; font-family: 'Arimo', sans-serif; margin-bottom: 1em;">Manage Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php include '../-TRX-PHP-Finals/includes/footer.php'; ?>
