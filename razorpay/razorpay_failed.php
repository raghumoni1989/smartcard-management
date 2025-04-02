<?php
session_start();

$error_message = isset($_GET['error']) ? $_GET['error'] : 'Unknown error occurred.';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Payment Failed</h2>
            <p><?php echo htmlspecialchars($error_message); ?></p>
            <a href="../smartcard_payment.php" class="btn btn-primary">Try Again</a>
        </div>
    </div>
</body>
</html>
