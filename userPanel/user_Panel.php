<?php
require '../conFile/conection.php';
require '../conFile/register.php';

// Session code
if (!isset($_SESSION)) {
    session_start();
}
// Session code end
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'user-header.php';
    ?>
    <style>
        body {

            background-color: #26c2d1;
        }

        /* Popup styles */
        .popup {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #1ba6d1;
            color: #fff;
            border-radius: 8px;
            z-index: 1000;
            text-align: center;
        }

        .popup.show {
            display: block;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <?php
    include 'navigation.php';
    ?>

    <!-- Session code with welcome msg -->
    <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        // The popup will be triggered by JavaScript
    }
    ?>

    <!-- Popup HTML -->
    <div id="welcomePopup" class="popup">
        <h1>Welcome to the website, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const popup = document.getElementById('welcomePopup');

            // Show the popup
            popup.classList.add('show');

            // Hide the popup after 5 seconds
            setTimeout(() => {
                popup.classList.remove('show');
            }, 5000);
        });
    </script>

    <script>
        const menuToggle = document.querySelector('.menuToggle');
        const navigation = document.querySelector('.navigation');
        menuToggle.onclick = function () {
            navigation.classList.toggle('open');
        }

        const list = document.querySelectorAll('.list');
        function activeLink() {
            list.forEach((item) =>
                item.classList.remove('active'));
            this.classList.add('active');
        }
        list.forEach((item) =>
            item.addEventListener('click', activeLink));
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- JS code end -->

</body>

</html>