<?php
session_start();
require_once '../-TRX-PHP-Finals/config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../-TRX-PHP-Finals/includes/header.php';

?>

<html>
    <section class="section1">
        <div class="section1_left">
            <h2>
                About Us
            </h2>
            <p>
                LibraX is a comprehensive Library Management System developed by Domeld, Mike, Arvin, and Sean. Our system streamlines book borrowing, returns, and catalog management—making library experiences smarter, faster, and more accessible for everyone.
            </p>
        </div>
        <div class= "section1_right">
            <h2>LIBRAX.</h2>
        </div>
    </section>
</html>

<?php include '../-TRX-PHP-Finals/includes/footer.php'; ?>
