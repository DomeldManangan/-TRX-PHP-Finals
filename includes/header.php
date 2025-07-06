<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Library System</h1>
        <nav>
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['username'])): ?>
                <span>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (<?= $_SESSION['role'] ?>)</span>
                <a href="logout.php">Logout</a>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="add.php">Add Book</a>
                    <a href="manage_users.php">Manage Users</a>
                <?php else: ?>
                    <a href="mybooks.php">My Books</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main> 