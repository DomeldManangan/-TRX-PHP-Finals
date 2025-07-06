<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../includes/header.php';

// Fetch all books
$stmt = $pdo->query('SELECT * FROM books ORDER BY created_at DESC');
$books = $stmt->fetchAll();
?>
<h2>Book List</h2>
<?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="add.php"><button>Add New Book</button></a>
<?php endif; ?>
<table>
    <tr>
        <th>Book ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Genre</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= htmlspecialchars($book['book_id']) ?></td>
        <td><?= htmlspecialchars($book['title']) ?></td>
        <td><?= htmlspecialchars($book['author']) ?></td>
        <td><?= htmlspecialchars($book['published_year']) ?></td>
        <td><?= htmlspecialchars($book['genre']) ?></td>
        <td><?= htmlspecialchars($book['status']) ?></td>
        <td>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="edit.php?id=<?= $book['id'] ?>">Edit</a>
            <?php elseif ($_SESSION['role'] === 'student' && $book['status'] === 'Available'): ?>
                <a href="borrow.php?book_id=<?= $book['id'] ?>" onclick="return confirm('Borrow this book?')">Borrow</a>
            <?php elseif ($_SESSION['role'] === 'student' && $book['status'] === 'Borrowed'): ?>
                <span style="color: #999;">Borrowed</span>
            <?php elseif ($_SESSION['role'] === 'student' && $book['status'] === 'Archived'): ?>
                <span style="color: #999;">Archived</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?>