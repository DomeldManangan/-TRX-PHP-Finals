<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$stmt = $pdo->query('SELECT id, username, role FROM users');
$users = $stmt->fetchAll();
include '../includes/header.php';
?>
<h2>Manage Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= $user['role'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?> 