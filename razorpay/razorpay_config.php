<?php
session_start();
require('../razorpay/razorpay_config.php');
require('../vendor/autoload.php');

use Razorpay\Api\Api;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

// Fixed Payment Amount: 1 INR
$amount = 1 * 100; // Convert to paise (1 INR = 100 paise)
$orderData = [
    'receipt' => 'RZP_' . time(),
    'amount' => $amount,
    'currency' => 'INR',
    'payment_capture' => 1 // Auto-capture payment
];

$order = $api->order->create($orderData);
$_SESSION['razorpay_order_id'] = $order['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Card Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <form id="razorpay-form">
        <script>
            var options = {
                "key": "<?php echo RAZORPAY_KEY_ID; ?>",
                "amount": "<?php echo $amount; ?>",
                "currency": "INR",
                "name": "Smart Card Booking",
                "description": "Payment for Smart Card Booking",
                "order_id": "<?php echo $order['id']; ?>",
                "handler": function(response) {
                    window.location.href = "razorpay_success.php?payment_id=" + response.razorpay_payment_id + "&order_id=" + response.razorpay_order_id;
                },
                "theme": {
                    "color": "#007bff"
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        </script>
    </form>
</body>
</html>
