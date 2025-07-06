<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT b.book_id, b.title, bb.borrow_date, bb.due_date, bb.return_date, bb.fine, bb.id as borrow_id
    FROM borrowed_books bb
    JOIN books b ON bb.book_id = b.id
    WHERE bb.user_id = ?
    ORDER BY bb.borrow_date DESC');
$stmt->execute([$user_id]);
$books = $stmt->fetchAll();
include '../includes/header.php';
?>
<h2>My Borrowed Books</h2>
<table>
    <tr>
        <th>Book ID</th>
        <th>Title</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
        <th>Return Date</th>
        <th>Fine</th>
        <th>Action</th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= htmlspecialchars($book['book_id']) ?></td>
        <td><?= htmlspecialchars($book['title']) ?></td>
        <td><?= htmlspecialchars($book['borrow_date']) ?></td>
        <td><?= htmlspecialchars($book['due_date']) ?></td>
        <td><?= $book['return_date'] ? htmlspecialchars($book['return_date']) : 'Not returned' ?></td>
        <td><?= $book['fine'] ? '₱' . number_format($book['fine'], 2) : '-' ?></td>
        <td>
            <?php if (!$book['return_date']): ?>
                <a href="return.php?borrow_id=<?= $book['borrow_id'] ?>">Return</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?> 