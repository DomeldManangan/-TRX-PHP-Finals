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

    <section class="mission-vision-section">
        <h2>Mission</h2>
        <p>
            Our mission is to provide an efficient, user-friendly library management system that enhances the experience of both library staff and patrons by simplifying book borrowing, returns, and catalog management.
        </p>
        <h2>Vision</h2>
        <p>
            We envision a future where libraries are seamlessly integrated with technology, fostering a love for reading and learning by making resources easily accessible to everyone.
        </p>
    </section>

    <section class="team-section">
        <h2>Our Team</h2>
        <div class="team-cards">
            <div class="team-card">
                <img src="../-TRX-PHP-Finals/assets/img/6.png" alt="Team Member 1">
                <h3>Domeld Manangan</h3>
                <p>Developer, Front-end</p>
            </div>
            <div class="team-card">
                <img src="../-TRX-PHP-Finals/assets/img/mike.png" alt="Team Member 2">
                <h3>Mike Acosta</h3>
                <p>Developer, Back-end</p>
            </div>
            <div class="team-card">
                <img src="../-TRX-PHP-Finals/assets/img/7.png" alt="Team Member 3">
                <h3>Arvin Tumbagahon</h3>
                <p>Developer, Back-end</p>
            </div>
            <div class="team-card">
                <img src="../-TRX-PHP-Finals/assets/img/8.png" alt="Team Member 4">
                <h3>Sean Mojica</h3>
                <p>Developer, Front-end</p>
            </div>
        </div>
    </section>
</html>


<?php include '../-TRX-PHP-Finals/includes/footer.php'; ?>
