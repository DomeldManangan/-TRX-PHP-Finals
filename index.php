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
    <section class=hero>
            <img src="./assets/img/library picture.jpg" alt="wallpaper" class="wallpaper">

            <div class="hero-content">
          <h1>LIBRAX.</h1>
          <p>”Unlock knowledge. Discover stories. Feed your mind.”</p>
          <br>
          <a href="../-TRX-PHP-Finals/booklist.php" class="btn">Book List</a>
          </div>
    </section>
</html>

<?php include '../-TRX-PHP-Finals/includes/footer.php'; ?>

