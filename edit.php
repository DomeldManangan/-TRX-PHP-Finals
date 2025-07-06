<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

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
$title = $book['title'];
$author = $book['author'];
$year = $book['published_year'];
$genre = $book['genre'];
$bookId = $book['book_id'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $year = trim($_POST['published_year']);
    $genre = trim($_POST['genre']);

    // Validation
    if ($title === '') $errors[] = 'Title is required.';
    if ($author === '') $errors[] = 'Author is required.';
    if ($year === '' || !is_numeric($year) || $year < 0) $errors[] = 'Valid year is required.';

    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE books SET title=?, author=?, published_year=?, genre=? WHERE id=?');
        $stmt->execute([$title, $author, $year, $genre, $id]);
        echo '<p class="success">Book updated successfully!</p>';
    }
}
?>
<h2>Edit Book</h2>
<?php if ($errors): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post">
    <label>Book ID: <input type="text" value="<?= htmlspecialchars($bookId) ?>" readonly></label>
    <label>Title: <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required></label>
    <label>Author: <input type="text" name="author" value="<?= htmlspecialchars($author) ?>" required></label>
    <label>Published Year: <input type="number" name="published_year" value="<?= htmlspecialchars($year) ?>" required></label>
    <label>Genre: <input type="text" name="genre" value="<?= htmlspecialchars($genre) ?>"></label>
    <button type="submit">Update Book</button>
</form>
<a href="index.php">Back to List</a>
<?php include '../includes/footer.php'; ?> 