<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="../../-TRX-PHP-Finals/assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../../-TRX-PHP-Finals/assets/img/LibraX_Logo_White_Removebg_SMALL_.png" alt="Library Logo" class="logo">
        </div>
        <div class="nav-container1">
            <nav>
            <a href="index.php">Home</a>
            <a href="about.php">About us</a>
            <a href="booklist.php">Book list</a>
             <?php if (isset($_SESSION['username'])): ?>
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
        </div>
        <div class="nav-container2">
            <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (<?= $_SESSION['role'] ?>)</span>
            <?php endif; ?>
        </div>
    </header>
    <?php if (in_array(basename($_SERVER['PHP_SELF']), ['booklist.php', 'mybooks.php'])): ?>
    <main>
    <?php endif; ?>
