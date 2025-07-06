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

// Check if borrow_id is provided
if (!isset($_GET['borrow_id']) || empty($_GET['borrow_id'])) {
    $error = 'Invalid borrow record.';
} else {
    $borrow_id = $_GET['borrow_id'];
    
    // Verify that this borrow record belongs to the current user
    $stmt = $pdo->prepare('SELECT bb.*, b.title, b.book_id as book_code 
        FROM borrowed_books bb 
        JOIN books b ON bb.book_id = b.id 
        WHERE bb.id = ? AND bb.user_id = ? AND bb.return_date IS NULL');
    $stmt->execute([$borrow_id, $user_id]);
    $borrow_record = $stmt->fetch();
    
    if (!$borrow_record) {
        $error = 'Invalid borrow record or book already returned.';
    } else {
        // Process the return
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $pdo->beginTransaction();
                
                // Calculate fine if book is returned late
                $due_date = new DateTime($borrow_record['due_date']);
                $return_date = new DateTime();
                $fine = 0;
                
                if ($return_date > $due_date) {
                    $days_late = $return_date->diff($due_date)->days;
                    $fine = $days_late * 5.00; // ₱5.00 per day late
                }
                
                // Update the borrowed_books record
                $update_stmt = $pdo->prepare('UPDATE borrowed_books 
                                            SET return_date = CURRENT_DATE, fine = ? 
                                            WHERE id = ? AND user_id = ?');
                $update_stmt->execute([$fine, $borrow_id, $user_id]);
                
                // Update the book status to Available
                $book_update_stmt = $pdo->prepare('UPDATE books 
                                                 SET status = "Available" 
                                                 WHERE id = ?');
                $book_update_stmt->execute([$borrow_record['book_id']]);
                
                $pdo->commit();
                
                $message = 'Book "' . htmlspecialchars($borrow_record['title']) . '" has been successfully returned.';
                if ($fine > 0) {
                    $message .= ' Fine: ₱' . number_format($fine, 2);
                }
                
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = 'An error occurred while processing the return. Please try again.';
            }
        }
    }
}

include '../-TRX-PHP-Finals/includes/header.php';
?>

<div class="container">
    <h2>Return Book</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
            <br><a href="mybooks.php">Back to My Books</a>
        </div>
    <?php elseif ($message): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($message) ?>
            <br><a href="mybooks.php">Back to My Books</a>
        </div>
    <?php elseif ($borrow_record): ?>
        <div class="return-confirmation">
            <h3>Confirm Book Return</h3>
            <div class="book-details">
                <p><strong>Book Title:</strong> <?= htmlspecialchars($borrow_record['title']) ?></p>
                <p><strong>Book ID:</strong> <?= htmlspecialchars($borrow_record['book_code']) ?></p>
                <p><strong>Borrow Date:</strong> <?= htmlspecialchars($borrow_record['borrow_date']) ?></p>
                <p><strong>Due Date:</strong> <?= htmlspecialchars($borrow_record['due_date']) ?></p>
                
                <?php
                $due_date = new DateTime($borrow_record['due_date']);
                $today = new DateTime();
                if ($today > $due_date) {
                    $days_late = $today->diff($due_date)->days;
                    $estimated_fine = $days_late * 5.00;
                    echo '<p><strong>Estimated Fine:</strong> ₱' . number_format($estimated_fine, 2) . ' (' . $days_late . ' days late)</p>';
                } else {
                    echo '<p><strong>Status:</strong> On time</p>';
                }
                ?>
            </div>
            
            <form method="POST" onsubmit="return confirm('Are you sure you want to return this book?');">
                <button type="submit" class="btn btn-primary">Confirm Return</button>
                <a href="mybooks.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    <?php endif; ?>
</div>



<?php include '../-TRX-PHP-Finals/includes/footer.php'; ?> 