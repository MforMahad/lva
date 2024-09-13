<?php
require '../conFile/conection.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$error = "";
$msg = "";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('location:userpanel.php');
    exit;
} else {
    // Check if a payment ID is set for deletion
    if (isset($_REQUEST['payid'])) {
        $payid = intval($_GET['payid']);
        $email = $_SESSION['user_email'];

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT user_email FROM payments WHERE PaymentId=? AND user_email=?");
        if ($stmt === FALSE) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param('is', $payid, $email);
        if ($stmt->execute() === FALSE) {
            die('Execute failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Payment exists, proceed with deletion
            $stmt = $conn->prepare("DELETE FROM payments WHERE PaymentId=? AND user_email=?");
            if ($stmt === FALSE) {
                die('Prepare failed: ' . $conn->error);
            }
            $stmt->bind_param('is', $payid, $email);
            if ($stmt->execute() === FALSE) {
                die('Execute failed: ' . $stmt->error);
            }

            $msg = "Payment record deleted successfully";
        } else {
            $error = "Payment not found or you don't have permission to delete this record.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'user-header.php'; ?>

    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #26c2d1;
            /* Light grey background for the page */
        }

        .form-container {
            max-width: 55%;
            /* Reduced width for a smaller form container */
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            /* White background for the form */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Slightly darker shadow for better emphasis */
        }

        form {
            margin: 0;
            text-align: center;
            /* Center-align the form content */
        }

        .table-container {
            display: flex;
            justify-content: center;
            /* Center the table container */
            margin: 0 auto;
        }

        .table {
            width: 100%;
            /* Make the table full-width within the container */
            max-width: 800px;
            /* Set a maximum width for the table */
            border-collapse: collapse;
            background: #fff;
            /* Background for the table */
            border-radius: 8px;
            overflow: hidden;
            /* Rounded corners for table */
            margin: 0 auto;
            /* Center the table */
        }

        .table thead {
            background-color: #007bff;
            /* Blue background for the header */
            color: #fff;
            /* White text color for header */
        }

        .table th,
        .table td {
            padding: 10px;
            /* Reduced padding for a more compact look */
            text-align: center;
            /* Center-align text in table cells */
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #0056b3;
            /* Darker blue for header cells */
            font-weight: bold;
            font-size: 12px;
            /* Bold text for headers */
        }

        .table td {
            background-color: #fafafa;
            /* Very light grey for data cells */
        }

        .table td a {
            color: #007bff;
            /* Blue color for links */
            text-decoration: none;
            font-weight: bold;
            /* Bold links for emphasis */
        }

        .table td a:hover {
            text-decoration: underline;
        }

        .errorWrap {
            color: #d9534f;
            /* Red color for error messages */
            padding: 10px;
            border: 1px solid #d9534f;
            border-radius: 5px;
            background: #f8d7da;
            margin-bottom: 20px;
        }

        .succWrap {
            color: #5bc0de;
            /* Blue color for success messages */
            padding: 10px;
            border: 1px solid #5bc0de;
            border-radius: 5px;
            background: #d9edf7;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .table thead {
                display: none;
                /* Hide header on small screens */
            }

            .table td {
                display: block;
                width: 100%;
                box-sizing: border-box;
                text-align: right;
                position: relative;
                padding-left: 50%;
                padding-bottom: 20px;
                border: none;
                border-bottom: 1px solid #ddd;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding: 8px;
                font-weight: bold;
                background: #fafafa;
                text-align: left;
                border-right: 1px solid #ddd;
            }

        }
    </style>
</head>

<body>
    <?php include 'navigation.php'; ?>

    <div class="form-container">
        <form name="chngpwd" method="post" onSubmit="return valid();">
            <?php if ($error) { ?>
                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
            <?php } else if ($msg) { ?>
                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
            <?php } ?>
            <table class="table">
                <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Payment Id</th>
                        <th>Package Id</th>
                        <th>Live Package Id</th>
                        <th>Stripe Charge Id</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Payed Date n Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $email = $_SESSION['user_email'];

                    // Prepare and execute the query
                    $stmt = $conn->prepare("SELECT PaymentId, PackageId, LivePackageId, StripeChargeId, Amount, Description, CreatedDate FROM payments WHERE user_email=?");
                    if ($stmt === FALSE) {
                        die('Prepare failed: ' . $conn->error);
                    }
                    $stmt->bind_param('s', $email);
                    if ($stmt->execute() === FALSE) {
                        die('Execute failed: ' . $stmt->error);
                    }
                    $result = $stmt->get_result();
                    $cnt = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr align="center">
                                <td><?php echo htmlentities($cnt); ?></td>
                                <td><?php echo htmlentities($row['PaymentId']); ?></td>
                                <td><?php echo htmlentities($row['PackageId']); ?></td>
                                <td><?php echo htmlentities($row['LivePackageId']); ?></td>
                                <td><?php echo htmlentities($row['StripeChargeId']); ?></td>
                                <td><?php echo htmlentities($row['Amount']); ?></td>
                                <td><?php echo htmlentities($row['Description']); ?></td>
                                <td><?php echo htmlentities($row['CreatedDate']); ?></td>
                            </tr>
                            <?php $cnt++;
                        }
                    } else {
                        echo "<tr><td colspan='8' align='center'>No payments found</td></tr>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </form>
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