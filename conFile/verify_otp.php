<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection file
require 'conection.php'; // Adjust the path as needed

// Handle OTP verification and data insertion
if (isset($_POST['verify_otp'])) {
    $user_otp = $_POST['otp'];
    $user_email = $_POST['email']; // Email passed from the form or query string
    $otp_expiry = $_POST['otp_expiry']; // OTP expiry passed from the form or query string

    // Debugging output
    echo "<pre>";
    echo "Received OTP: $user_otp\n";
    echo "User Email: $user_email\n";
    echo "OTP Expiry: $otp_expiry\n";
    echo "</pre>";

    // Fetch stored OTP and its expiry from the database
    $otp_query = "SELECT * FROM `otp_verification` WHERE `user_email` = ? AND `otp` = ?";
    if ($stmt = $conn->prepare($otp_query)) {
        $stmt->bind_param('ss', $user_email, $user_otp);
        $stmt->execute();
        $otp_result = $stmt->get_result();

        if ($otp_result && $otp_result->num_rows > 0) {
            $otp_data = $otp_result->fetch_assoc();

            // Debugging output
            echo "<pre>";
            print_r($otp_data);
            echo "</pre>";

            // Check if OTP is expired
            if (time() > $otp_data['otp_expiry']) {
                echo "<script>alert('OTP has expired. Please request a new one.'); window.location.href='../index.php';</script>";
                exit();
            }

            // OTP is valid, proceed with data insertion
            $query = "INSERT INTO `user_reg` (`user_image`, `user_name`, `user_email`, `user_pass`, `created_date`) 
                      VALUES (?, ?, ?, ?, NOW())";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param('ssss', $_POST['user_image'], $_POST['user_name'], $_POST['user_email'], $_POST['user_pass']);
                if ($stmt->execute()) {
                    echo "<script>alert('Registration successful.'); window.location.href='../index.php';</script>";
                } else {
                    echo "<script>alert('Error inserting data.'); window.location.href='./verify_otp.php';</script>";
                }
            } else {
                echo "<script>alert('Error preparing insertion query: " . htmlspecialchars($conn->error) . "'); window.location.href='./verify_otp.php';</script>";
            }

            // Delete OTP after successful verification
            $delete_query = "DELETE FROM `otp_verification` WHERE `user_email` = ?";
            if ($stmt = $conn->prepare($delete_query)) {
                $stmt->bind_param('s', $user_email);
                $stmt->execute();
            } else {
                echo "<script>alert('Error preparing deletion query: " . htmlspecialchars($conn->error) . "'); window.location.href='./verify_otp.php';</script>";
            }

        } else {
            echo "<script>alert('Invalid OTP. Please try again.'); window.location.href='./verify_otp.php';</script>";
        }
    } else {
        echo "<script>alert('Error preparing OTP query: " . htmlspecialchars($conn->error) . "'); window.location.href='./verify_otp.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .container h2 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="otp">Enter OTP:</label>
                <input type="text" id="otp" name="otp" required>
            </div>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['user_email'] ?? ''); ?>">
            <input type="hidden" name="otp_expiry" value="<?php echo htmlspecialchars($_GET['otp_expiry'] ?? ''); ?>">
            <div class="form-group">
                <button type="submit" name="verify_otp">Verify OTP</button>
            </div>
        </form>
    </div>
</body>

</html>