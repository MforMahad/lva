<?php
// Start session and include database connection
session_start();
require '../conFile/conection.php';

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<p>You are not logged in. Redirecting to login page...</p>";
    header('Location: user_Panel.php');
    exit;
}

// Check if user_email is set in the session
if (!isset($_SESSION['user_email'])) {
    echo "<p>Session variable 'user_email' is not set. Redirecting to login page...</p>";
    header('Location: user_Panel.php');
    exit;
}

// Retrieve user email from session
$userEmail = $_SESSION['user_email'];

// Prepare the SQL query
$sql = "SELECT LiveLink FROM livebookingtable WHERE user_email = ? AND status = 1";
$stmt = $conn->prepare($sql);

// Check if prepare was successful
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

// Bind the parameters
$stmt->bind_param('s', $userEmail);

// Execute the query
if (!$stmt->execute()) {
    die("Execute failed: " . htmlspecialchars($stmt->error));
}

// Get the result
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $liveLink = $row['LiveLink'];
} else {
    $liveLink = 'No live stream available';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'user-header.php'; ?>
    <style>
        .live-link-container {
            padding: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #1ba6d1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .live-link-container p {
            font-size: 20px;
            color: #333;
            font-weight: bold;
            margin: 0;
        }

        .live-link-container a {
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            background-color: #007bff;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .live-link-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include 'navigation.php'; ?>

    <div class="live-link-container">
        <?php if ($liveLink === 'No live stream available') { ?>
            <p>To Watch Live Click On the Link <?php echo htmlspecialchars($liveLink); ?></p>
        <?php } else { ?>
            <a href="<?php echo htmlspecialchars($liveLink); ?>" target="_blank">Watch Live Stream</a>
        <?php } ?>
    </div>

    <script>
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