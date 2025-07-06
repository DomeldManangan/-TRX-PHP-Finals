<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<p class="error">Invalid book ID.</p>';
    include '../includes/footer.php';
    exit;
}
$id = (int)$_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = ?');
$stmt->execute([$id]);
$book = $stmt->fetch();
if (!$book) {
    echo '<p class="error">Book not found.</p>';
    include '../includes/footer.php';
    exit;
}
// Delete book
$stmt = $pdo->prepare('DELETE FROM books WHERE id = ?');
$stmt->execute([$id]);
header('Location: index.php');
exit; 