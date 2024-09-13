<?php
require '../conFile/conection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: user_Panel.php');
    exit;
}

// Handle the password change form submission
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current user's password from the database
    $user_name = $_SESSION['user_name'];
    $query = "SELECT user_pass FROM user_reg WHERE user_name='$user_name'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['user_pass'];

        // Verify the current password
        if (password_verify($current_password, $hashed_password)) {
            if ($new_password === $confirm_password) {
                // Hash the new password
                $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Update the password in the database
                $update_query = "UPDATE user_reg SET user_pass='$new_hashed_password' WHERE user_name='$user_name'";
                if (mysqli_query($conn, $update_query)) {
                    echo "<script>alert('Password changed successfully'); window.location.href='change-password.php';</script>";
                } else {
                    echo "<script>alert('Error updating password'); window.location.href='change-password.php';</script>";
                }
            } else {
                echo "<script>alert('New password and confirmation do not match'); window.location.href='change-password.php';</script>";
            }
        } else {
            echo "<script>alert('Current password is incorrect'); window.location.href='change-password.php';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='change-password.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include 'user-header.php';

    ?>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #26c2d1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            border: 1px solid #000;
            background-color: #f8f9fa;
            padding: 20px;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #555;
        }

        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            background-color: #f8f8f8;
            transition: border-color 0.3s ease-in-out;
        }

        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }

        button[type="submit"] {
            width: 100%;
            padding: 0.8rem;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
                max-width: 100%;
            }

            h2 {
                font-size: 1.5rem;
            }

            button[type="submit"] {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>


    <!-- navigation code -->
    <?php
    include 'navigation.php';

    ?>
    <!-- navigation code end -->

    <div class="container mt-5">
        <h2>Change Password</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
        </form>
    </div>

    <!-- js code -->

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

    <!-- js code end -->
</body>

</html>