<?php
// Start the session and include necessary files
require '../conFile/conection.php';
require 'vendor/autoload.php';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set Stripe API key
\Stripe\Stripe::setApiKey('sk_test_51N1rftHJKTWnYqdBXfEJMj4NUTTZSFmoVhNhB85XENkoeXD8riBWZWpLAc1OejXhID833ytR3GFvPPQYe9EYMlec00wY1sFIp2');

header('Content-Type: application/json');

// Get and decode the JSON input
$input = file_get_contents('php://input');
$body = json_decode($input);

// Check if user email is set in session
if (!isset($_SESSION['user_email']) || empty($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'error' => 'User email is not set in session']);
    exit;
}

$user_email = $_SESSION['user_email']; // User email from session
$token = $body->token ?? null;
$booking = $_SESSION['booking'] ?? null;
$live_booking = $_SESSION['live_booking'] ?? null;

// Debugging: Print booking data
// echo '<pre>'; print_r($_SESSION); echo '</pre>';

// Check if booking data is set
if (!$booking && !$live_booking) {
    echo json_encode(['success' => false, 'error' => 'No booking data found.']);
    exit;
}

// Extract package ID and live package ID from session data
$packageId = isset($booking['PackageId']) ? intval($booking['PackageId']) : null;
$livePackageId = isset($live_booking['LivePackageId']) ? intval($live_booking['LivePackageId']) : null;

// Debugging: Print extracted IDs
// echo '<pre>'; print_r(['PackageId' => $packageId, 'LivePackageId' => $livePackageId]); echo '</pre>';

if (!$token) {
    echo json_encode(['success' => false, 'error' => 'Token not provided']);
    exit;
}

try {
    // Determine the amount and description based on the type of package
    if ($packageId) {
        $amount = 2000; // Amount in cents (e.g., $20.00)
        $description = 'You have been charged for the package';
    } elseif ($livePackageId) {
        $amount = 3000; // Example amount for a live package in cents (e.g., $30.00)
        $description = 'You have been charged for the live package';
    } else {
        echo json_encode(['success' => false, 'error' => 'No valid package ID provided']);
        exit;
    }

    // Create a charge with Stripe
    $charge = \Stripe\Charge::create([
        'amount' => $amount, // Amount determined above
        'currency' => 'usd',
        'source' => $token,
        'description' => $description,
    ]);

    // Check if charge was successful
    if ($charge->status !== 'succeeded') {
        echo json_encode(['success' => false, 'error' => 'Payment not successful']);
        exit;
    }

    // Prepare data for database insertion
    $stripeChargeId = $charge->id;
    $currency = $charge->currency;
    $status = $charge->status;
    $createdDate = date('Y-m-d H:i:s', $charge->created);

    // Insert payment details into the database
    $stmt = $conn->prepare("
        INSERT INTO payments (PaymentId, user_email, PackageId, LivePackageId, StripeChargeId, Amount, Currency, Description, Status, CreatedDate)
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare error: ' . $conn->error]);
        exit;
    }

    // Bind parameters: ensure packageId and livePackageId are integers, and others are strings
    $stmt->bind_param('siissssss', $user_email, $packageId, $livePackageId, $stripeChargeId, $amount, $currency, $description, $status, $createdDate);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Payment successful and recorded in the database']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database execute error: ' . $stmt->error]);
    }

    $stmt->close();
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['success' => false, 'error' => 'Stripe API error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'General error: ' . $e->getMessage()]);
}

$conn->close();
?>