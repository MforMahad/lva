<?php
require '../conFile/conection.php';
session_start();

if (isset($_POST['submit'])) {
    $issue = $_POST['issue'];
    $description = $_POST['description'];

    // Check if user email is in session
    if (isset($_SESSION['logged_in']) && !empty($_SESSION['logged_in'])) {
        $email = $_SESSION['user_email'];
    } else {
        $email = ''; // Default to empty if not set
        $alertMessage = "User email not found in session.";
        header("Location: " . $_SERVER['PHP_SELF'] . "?alert=" . urlencode($alertMessage));
        exit();
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO tblissues (user_email, Issue, Description) VALUES (?, ?, ?)";

    // Initialize the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('sss', $email, $issue, $description);

        // Execute the statement
        if ($stmt->execute()) {
            $alertMessage = "Your issue has been submitted successfully!";
        } else {
            $alertMessage = "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $alertMessage = "Failed to prepare the SQL statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();

    // Redirect to the same page with an alert message
    header("Location: " . $_SERVER['PHP_SELF'] . "?alert=" . urlencode($alertMessage));
    exit();
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'user-header.php'; ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #26c2d1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .help-form {
            padding: 20px;
        }

        .form-header h4 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .form-header h4 {
                font-size: 20px;
            }
        }

        /* Alert Box Styles */
        .alert-box {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .alert-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        .alert-content p {
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }

        .alert-content .btn {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
        }

        .alert-content .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Navigation code -->
    <?php include 'navigation.php'; ?>
    <!-- Navigation code end -->

    <div class="container">
        <form name="help" method="post" class="help-form">
            <div class="form-header">
                <h4>HOW CAN WE HELP YOU</h4>
            </div>
            <div class="form-group">
                <label for="country">Select Issue</label>
                <select id="country" name="issue" class="form-control" required>
                    <option value="">Select Issue</option>
                    <option value="Booking Issues">Booking Issues</option>
                    <option value="Cancellation">Cancellation</option>
                    <option value="Refund">Refund</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input id="description" class="form-control" type="text" placeholder="Enter your description here..."
                    name="description" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Alert Box HTML -->
    <div id="alertBox" class="alert-box">
        <div class="alert-content">
            <p id="alertMessage"></p>
            <button id="closeAlert" class="btn btn-primary">Close</button>
        </div>
    </div>

    <!-- JS code -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if there is an alert message in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const alertMessage = urlParams.get('alert');

            if (alertMessage) {
                var alertBox = document.getElementById('alertBox');
                var alertMessageElem = document.getElementById('alertMessage');
                var closeAlert = document.getElementById('closeAlert');

                alertMessageElem.textContent = decodeURIComponent(alertMessage);
                alertBox.style.display = 'flex';

                closeAlert.onclick = function () {
                    alertBox.style.display = 'none';
                };
            }
        });

        const menuToggle = document.querySelector('.menuToggle');
        const navigation = document.querySelector('.navigation');
        menuToggle.onclick = function () {
            navigation.classList.toggle('open');
        }

        const list = document.querySelectorAll('.list');
        function activeLink() {
            list.forEach((item) => item.classList.remove('active'));
            this.classList.add('active');
        }
        list.forEach((item) => item.addEventListener('click', activeLink));
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>