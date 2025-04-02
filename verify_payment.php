<?php
session_start();
require 'config.php'; // Include Razorpay Key Config

// Get raw JSON input
$json_input = file_get_contents('php://input');
file_put_contents('payment_debug.log', date('Y-m-d H:i:s') . " - Raw JSON: " . $json_input . PHP_EOL, FILE_APPEND);

// Check if JSON input is empty
if (empty($json_input)) {
    echo json_encode(['success' => false, 'error' => 'No JSON data received.']);
    exit();
}

$data = json_decode($json_input, true);

// Log the decoded data
file_put_contents('payment_debug.log', date('Y-m-d H:i:s') . " - Decoded Data: " . print_r($data, true) . PHP_EOL, FILE_APPEND);

// Validate JSON input
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON format.']);
    exit();
}

// Check if payment_id is received
if (!empty($data['payment_id'])) {
    $_SESSION['smartcard_booking']['payment'] = [
        'payment_id' => $data['payment_id'],
        'status' => 'verified'
    ];

    echo json_encode(['success' => true, 'message' => 'Payment verified successfully!']);
    exit();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid payment ID received.']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartcard Payment Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateSidebar() {
            document.querySelectorAll('.sidebar ul li').forEach((item, index) => {
                if (index < 4) {
                    item.classList.add('completed');
                }
            });
        }
    </script>
    <style>
        body { background-color: #f8f9fa; height: 100vh; margin: 0; display: flex; }
        .container { display: flex; width: 100%; height: 100vh; }
        .sidebar {
            width: 300px; background: white; color: black; padding: 20px;
            border-right: 1px solid #ccc; height: 100vh; overflow-y: auto; flex-shrink: 0;
            transition: all 0.3s ease-in-out;
        }
        .sidebar h5 { font-weight: bold; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li {
            padding: 12px; margin-bottom: 8px; border: 1px solid #ddd;
            border-radius: 5px; background: #f8f8f8; cursor: pointer;
            text-align: left; font-weight: bold;
            transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
        }
        .sidebar ul li:hover { transform: scale(1.02); }
        .sidebar ul li.active { background: #d6eaff; border-color: #007bff; }
        .sidebar ul li.completed { background: #c8e6c9; border-color: #28a745; }
        .content { flex-grow: 1; display: flex; justify-content: center; align-items: center; padding: 0; margin: 0; }
        .card { width: 100%; max-width: 900px; padding: 40px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h5>Form Particulars</h5>
            <ul>
                <li class="completed">1. Book Smartcard</li>
                <li class="completed">2. Postal Address</li>
                <li class="completed">3. Payment</li>
                <li class="active">4. Verify Payment</li>
                <li>5. Summary</li>
            </ul>
        </div>
        <div class="content">
            <div class="card">
                <h3>Payment Verification</h3>
                <div id="verificationStatus" class="alert alert-success">✅ Payment verified successfully! Please proceed to the next step.</div>
            </div>
        </div>
    </div>
</body>
</html>
