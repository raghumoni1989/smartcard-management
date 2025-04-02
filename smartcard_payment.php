<?php
session_start();
require 'config.php'; // Include config file for Razorpay Key

// Save form data when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    if (!empty($_POST['amount']) && is_numeric($_POST['amount'])) {
        $_SESSION['smartcard_booking']['amount'] = trim($_POST['amount']);
        $message = "Form saved successfully!";
    } else {
        $message = "Invalid amount. Please enter a valid amount.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartcard Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function processPayment() {
            var options = {
                "key": "<?php echo RAZORPAY_KEY_ID; ?>",
                "amount": <?php echo isset($_SESSION['smartcard_booking']['amount']) ? $_SESSION['smartcard_booking']['amount'] * 100 : 100; ?>,
                "currency": "INR",
                "name": "Smart Card Booking",
                "description": "Payment for Smart Card",
                "image": "https://yourlogo.com/logo.png",
                "handler": function (response) {
                    console.log("Payment ID:", response.razorpay_payment_id);
                    fetch('summary.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ payment_id: response.razorpay_payment_id })
                    }).then(response => response.json())
                      .then(data => {
                          console.log("Verification Response:", data);
                          if (data.success) {
                              document.getElementById('paymentSuccess').style.display = 'block';
                              updateSidebar();
                              setTimeout(() => {
                                  window.location.href = 'summary.php';
                              }, 2000);
                          } else {
                              alert("Payment verification failed: " + data.error);
                          }
                      }).catch(error => console.error("Error in verification:", error));
                },
                "theme": { "color": "#007bff" }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        }

        function updateSidebar() {
            document.querySelectorAll('.sidebar ul li').forEach((item, index) => {
                if (index < 3) {
                    item.classList.add('completed');
                }
                if (index === 2) {
                    item.classList.add('active');
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
        .sidebar p { font-size: 14px; color: #555; }
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
        #paymentSuccess {
            display: none;
            margin-top: 20px;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h5>Form Particulars</h5>
            <p>Click section to jump to the respective section</p>
            <ul>
                <li class="completed">1. Book Smartcard</li>
                <li class="completed">2. Postal Address</li>
                <li class="active">3. Payment</li>
                <li>4. Summary</li>
            </ul>
        </div>

        <div class="content">
            <div class="card">
                <h3>Smartcard Payment</h3>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success animate__animated animate__fadeIn"><?= htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="text" class="form-control" name="amount" value="<?= htmlspecialchars($_SESSION['smartcard_booking']['amount'] ?? '1.00') ?>" readonly>
                    </div>
                    <button type="submit" name="save" class="btn btn-secondary">Save & Continue Later</button>
                    <button type="button" class="btn btn-primary" onclick="processPayment()">Proceed to Payment</button>
                </form>
                <div id="paymentSuccess" class="alert alert-success">✅ Payment successful! Redirecting...</div>
            </div>
        </div>
    </div>
</body>
</html>
