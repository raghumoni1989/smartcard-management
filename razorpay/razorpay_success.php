<?php
session_start();
require('../config.php');
require('../vendor/autoload.php');

use Razorpay\Api\Api;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

if (!isset($_GET['payment_id']) || !isset($_GET['order_id'])) {
    die("Invalid request");
}

$payment_id = $_GET['payment_id'];
$order_id = $_GET['order_id'];

try {
    // Fetch payment details from Razorpay
    $payment = $api->payment->fetch($payment_id);
    
    if ($payment->status == 'captured') {
        // Update database with payment status
        $stmt = $conn->prepare("UPDATE payments SET payment_status = 'Success', payment_id = ? WHERE order_id = ?");
        $stmt->bind_param("ss", $payment_id, $order_id);
        $stmt->execute();
        
        $_SESSION['payment_status'] = 'Success';
        header("Location: summary.php"); // Redirect to summary page
        exit();
    } else {
        throw new Exception("Payment failed or not captured.");
    }
} catch (Exception $e) {
    $_SESSION['payment_status'] = 'Failed';
    header("Location: razorpay_failed.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>
