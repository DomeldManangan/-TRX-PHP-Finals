<?php
session_start();
require_once '../-TRX-PHP-Finals/config/db.php';

// Check if user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle book borrowing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    
    try {
        // Start transaction
        $pdo->beginTransaction();
        
        // Check if book exists and is available
        $stmt = $pdo->prepare('SELECT id, title, status FROM books WHERE id = ? AND status = "Available"');
        $stmt->execute([$book_id]);
        $book = $stmt->fetch();
        
        if (!$book) {
            throw new Exception('Book is not available for borrowing.');
        }
        
        // Check if user has already borrowed this book
        $stmt = $pdo->prepare('SELECT id FROM borrowed_books WHERE user_id = ? AND book_id = ? AND return_date IS NULL');
        $stmt->execute([$user_id, $book_id]);
        if ($stmt->fetch()) {
            throw new Exception('You have already borrowed this book.');
        }
        
        // Check if user has too many books borrowed (limit to 3 books)
        $stmt = $pdo->prepare('SELECT COUNT(*) as count FROM borrowed_books WHERE user_id = ? AND return_date IS NULL');
        $stmt->execute([$user_id]);
        $borrowed_count = $stmt->fetch()['count'];
        
        if ($borrowed_count >= 3) {
            throw new Exception('You can only borrow up to 3 books at a time. Please return some books first.');
        }
        
        // Calculate due date (14 days from today)
        $borrow_date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime('+14 days'));
        
        // Insert into borrowed_books table
        $stmt = $pdo->prepare('INSERT INTO borrowed_books (user_id, book_id, borrow_date, due_date) VALUES (?, ?, ?, ?)');
        $stmt->execute([$user_id, $book_id, $borrow_date, $due_date]);
        
        // Update book status to 'Borrowed'
        $stmt = $pdo->prepare('UPDATE books SET status = "Borrowed" WHERE id = ?');
        $stmt->execute([$book_id]);
        
        // Commit transaction
        $pdo->commit();
        
        $message = "Book '{$book['title']}' has been successfully borrowed. Due date: $due_date";
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}

// Handle GET request (when user clicks borrow link)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    
    // Get book details
    $stmt = $pdo->prepare('SELECT id, book_id, title, author, published_year, genre, status FROM books WHERE id = ?');
    $stmt->execute([$book_id]);
    $book = $stmt->fetch();
    
    if (!$book) {
        $error = 'Book not found.';
    } elseif ($book['status'] !== 'Available') {
        $error = 'This book is not available for borrowing.';
    }
}

include '../-TRX-PHP-Finals/includes/header.php';
?>

<h2>Borrow Book</h2>

<?php if ($message): ?>
    <div class="success-message">
        <?= htmlspecialchars($message) ?>
        <br><br>
        <a href="index.php">← Back to Book List</a>
        <a href="mybooks.php">View My Books</a>
    </div>
<?php elseif ($error): ?>
    <div class="error-message">
        <?= htmlspecialchars($error) ?>
        <br><br>
        <a href="index.php">← Back to Book List</a>
    </div>
<?php elseif (isset($book)): ?>
    <div class="book-details">
        <h3>Book Details</h3>
        <table>
            <tr>
                <th>Book ID:</th>
                <td><?= htmlspecialchars($book['book_id']) ?></td>
            </tr>
            <tr>
                <th>Title:</th>
                <td><?= htmlspecialchars($book['title']) ?></td>
            </tr>
            <tr>
                <th>Author:</th>
                <td><?= htmlspecialchars($book['author']) ?></td>
            </tr>
            <tr>
                <th>Published Year:</th>
                <td><?= htmlspecialchars($book['published_year']) ?></td>
            </tr>
            <tr>
                <th>Genre:</th>
                <td><?= htmlspecialchars($book['genre']) ?></td>
            </tr>
            <tr>
                <th>Status:</th>
                <td><?= htmlspecialchars($book['status']) ?></td>
            </tr>
        </table>
        
        <div class="borrow-info">
            <h4>Borrowing Information:</h4>
            <ul>
                <li>Borrow period: 14 days</li>
                <li>Due date: <?= date('Y-m-d', strtotime('+14 days')) ?></li>
                <li>Maximum books allowed: 3</li>
                <li>Late returns may incur fines</li>
            </ul>
        </div>
        
        <form method="POST" onsubmit="return confirm('Are you sure you want to borrow this book?')">
            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
            <button type="submit">Confirm Borrow</button>
            <a href="index.php" class="button">Cancel</a>
        </form>
    </div>
<?php else: ?>
    <div class="error-message">
        No book selected for borrowing.
        <br><br>
        <a href="index.php">← Back to Book List</a>
    </div>
<?php endif; ?>

<?php include '../-TRX-PHP-Finals/includes/footer.php'; ?> 