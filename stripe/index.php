<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../conFile/conection.php');

$error = "";
$msg = "";

if (isset($_POST['submit2'])) {
    try {
        if (!$conn instanceof mysqli) {
            throw new Exception('Database connection is not established.');
        }

        // Retrieve and sanitize inputs
        $LivePackageId = isset($_GET['lpkgid']) ? intval($_GET['lpkgid']) : 0;
        if ($LivePackageId == 0) {
            throw new Exception('No valid package ID found in the URL.');
        }

        $user_email = $_SESSION['user_email'] ?? '';
        $RegDate = date('Y-m-d H:i:s');
        $status = 0;
        $CancelledBy = NULL;
        $UpdationDate = NULL;

        if (empty($user_email)) {
            throw new Exception('User email is not set.');
        }

        // Check if the booking already exists
        $check_sql = "SELECT * FROM livebookingtable WHERE LivePackageId = ? AND user_email = ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt === false) {
            throw new Exception('Statement preparation failed: ' . $conn->error);
        }
        $check_stmt->bind_param("is", $LivePackageId, $user_email);
        $check_stmt->execute();
        $check_results = $check_stmt->get_result();

        if ($check_results->num_rows > 0) {
            $error = "You have already booked the seat.";
        } else {
            $sql = "INSERT INTO livebookingtable (LivePackageId, user_email, RegDate, status, CancelledBy, UpdationDate) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Statement preparation failed: ' . $conn->error);
            }

            // Bind the parameters
            $stmt->bind_param("ississ", $LivePackageId, $user_email, $RegDate, $status, $CancelledBy, $UpdationDate);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to payment page
                $_SESSION['live_booking'] = [
                    'LivePackageId' => $LivePackageId,
                    'UserEmail' => $user_email,
                ];
                header('Location: stripe/index.php?lpkgid=' . $LivePackageId);
                exit;
            } else {
                throw new Exception('Execution failed: ' . $stmt->error);
            }
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment Form</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .payment-form {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
            margin-top: 20px;
            display: block;
            /* Changed to display by default */
        }

        h1 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        #card-element {
            margin-bottom: 20px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: auto;
            margin: 0 auto;
            display: block;
        }

        button:hover {
            background-color: #218838;
        }

        #error-message {
            color: #dc3545;
            margin-top: 10px;
            font-size: 14px;
        }

        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            background-color: #ffffff;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .StripeElement--focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
    </style>
</head>

<body>
    <div class="payment-form">
        <h1>Payment Form</h1>
        <form id="payment-form">
            <div id="card-element"></div>
            <button type="submit">Pay</button>
            <div id="error-message"></div>
        </form>
    </div>

    <script>
        const stripe = Stripe('pk_test_51N1rftHJKTWnYqdBCveLeEFV1kpIKXEB4OUQ1dvWkmScfN8BFmaXIMBE0YFmhulBJN7xq0QlAAzISZeTBPidqUV000SwpmNvXl');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const errorMessage = document.getElementById('error-message');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const { token, error } = await stripe.createToken(card);

            if (error) {
                errorMessage.textContent = error.message;
            } else {
                const response = await fetch('charge.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ token: token.id }),
                });

                const result = await response.json();

                if (result.success) {
                    alert('Payment completed successfully!');
                    window.location.href = '../index.php'; // Refresh the page after alert is closed
                } else {
                    errorMessage.textContent = result.error;
                }
            }
        });
    </script>
</body>

</html>