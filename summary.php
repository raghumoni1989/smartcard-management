<?php
session_start();

// Debugging: Print session data
error_log(print_r($_SESSION, true));

if (!isset($_SESSION['user_data']) || !isset($_SESSION['payment_status'])) {
    header("Location: index.php");
    exit();
}
$user = $_SESSION['user_data'];
$payment_status = $_SESSION['payment_status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartcard Booking Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #f8f9fa; display: flex; height: 100vh; }
        .container { display: flex; width: 100%; height: 100vh; }
        .sidebar {
            width: 300px; background: #007bff; color: white; padding: 20px;
            border-right: 1px solid #ccc; height: 100vh; overflow-y: auto; flex-shrink: 0;
        }
        .sidebar h5 { font-weight: bold; color: white; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li {
            padding: 12px; margin-bottom: 8px; border-radius: 5px;
            background: rgba(255, 255, 255, 0.2); text-align: left;
            font-weight: bold; transition: 0.3s;
        }
        .sidebar ul li.active { background: white; color: #007bff; }
        .sidebar ul li.completed { background: #28a745; color: white; }
        .content { flex-grow: 1; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .card { width: 100%; max-width: 700px; padding: 30px; }
        @media print {
            .sidebar, .btn { display: none; }
            .card { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h5>Booking Steps</h5>
            <ul>
                <li class="completed">1. Book Smartcard</li>
                <li class="completed">2. Postal Address</li>
                <li class="completed">3. Payment</li>
                <li class="active">4. Summary</li>
            </ul>
        </div>

        <div class="content">
            <div class="card shadow-lg">
                <h3 class="text-center">Smartcard Booking Summary</h3>
                <div class="alert alert-<?php echo ($payment_status == 'Success') ? 'success' : 'danger'; ?>">
                    <strong>Payment Status:</strong> <?php echo htmlspecialchars($payment_status); ?>
                </div>
                <h5>Booking Details:</h5>
                <ul>
                    <li><strong>Name:</strong> <?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></li>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></li>
                    <li><strong>Smartcard Type:</strong> <?php echo htmlspecialchars($user['smartcard_type'] ?? 'N/A'); ?></li>
                    <li><strong>Delivery Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></li>
                </ul>
                <div class="text-center mt-3">
                    <button class="btn btn-primary" onclick="window.print()">Print Summary</button>
                    <button class="btn btn-success" onclick="window.location.href='index.php'">Go to Home</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>