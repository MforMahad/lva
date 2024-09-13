<!-- top header -->
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require './conFile/conection.php';
require './conFile/register.php';
?>
<div class="topheader">
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        // If the user is logged in, display the profile section
        ?>
        <div class="topheader1">
            <div class="menu-toggle1"></div>
            <div class="profile">
                <div class="user">
                    <?php
                    echo "<h3>$_SESSION[user_name]</h3>";
                    ?>
                </div>
                <div class="img-box1">
                    <img src='./upload/<?= $_SESSION['user_image'] ?>'>
                </div>
            </div>
            <div class="menu1">
                <ul>
                    <li><a href="./userpanel/user_panel.php"><i class="ph-bold ph-user"></i>&nbsp;Dashboard</a></li>
                    <li><a href='./conFile/logout.php'><i class='ph-bold ph-sign-out'></i>&nbsp;Sign Out</a></li>
                </ul>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- topheadercode end -->

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand me-lg-5 me-0" href="index.php">
                <img src="images/lva-logo2.png" class="logo-image img-fluid">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="upcoming-streams.php">Watch</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="package-list.php">Events</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>


                    <div class="ms-4">

                    </div>

                    <?php

                    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                        ?>
                        <button class="btnLogin-popup">Login</button>
                        <?php
                    }
                    ?>

                    <button style=" display:none;" class="btnLogin-popup"></button>
                </ul>
            </div>
        </div>
    </nav>
</div>