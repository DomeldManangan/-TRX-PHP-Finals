<?php
session_start();
require_once '../-TRX-PHP-Finals/config/db.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include '../-TRX-PHP-Finals/includes/header.php';

$title = $author = $year = $genre = '';
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
        // Generate Book ID
        $countStmt = $pdo->query('SELECT COUNT(*) FROM books');
        $count = $countStmt->fetchColumn() + 1;
        $countStr = str_pad($count, 5, '0', STR_PAD_LEFT);
        $titlePart = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $title), 0, 2));
        $monthPart = strtoupper(date('M', mktime(0,0,0, date('n'), 10, $year)));
        $dayPart = date('d'); // Day added to system
        $yearPart = $year;
        $genrePart = strtoupper(substr($genre, 0, 3));
        $bookId = $titlePart . $monthPart . $dayPart . $yearPart . '-' . $genrePart . $countStr;

        $stmt = $pdo->prepare('INSERT INTO books (book_id, title, author, published_year, genre) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$bookId, $title, $author, $year, $genre]);
        echo '<p class="success">Book added successfully! Book ID: ' . htmlspecialchars($bookId) . '</p>';
        // Reset form
        $title = $author = $year = $genre = '';
    }
}
?>
<h2>Add New Book</h2>
<?php if ($errors): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post">
    <label>Title: <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required></label>
    <label>Author: <input type="text" name="author" value="<?= htmlspecialchars($author) ?>" required></label>
    <label>Published Year: <input type="number" name="published_year" value="<?= htmlspecialchars($year) ?>" required></label>
    <label>Genre: <input type="text" name="genre" value="<?= htmlspecialchars($genre) ?>"></label>
    <button type="submit">Add Book</button>
</form>
<a href="index.php">Back to List</a>
<?php include '../-TRX-PHP-Finals/includes/footer.php'; ?> 