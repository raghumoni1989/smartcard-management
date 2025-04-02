<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['smartcard_booking']['address_line1'] = $_POST['address_line1'];
    $_SESSION['smartcard_booking']['address_line2'] = $_POST['address_line2'];
    $_SESSION['smartcard_booking']['city'] = $_POST['city'];
    $_SESSION['smartcard_booking']['state'] = $_POST['state'];
    $_SESSION['smartcard_booking']['zip'] = $_POST['zip'];

    if (isset($_POST['save'])) {
        $message = "Form saved successfully!";
    } else {
        header('Location: smartcard_payment.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postal Address</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (localStorage.getItem("postalAddress")) {
                let savedData = JSON.parse(localStorage.getItem("postalAddress"));
                document.querySelector("[name='address_line1']").value = savedData.address_line1 || "";
                document.querySelector("[name='address_line2']").value = savedData.address_line2 || "";
                document.querySelector("[name='city']").value = savedData.city || "";
                document.querySelector("[name='state']").value = savedData.state || "";
                document.querySelector("[name='zip']").value = savedData.zip || "";
            }
        });
        
        function saveFormData() {
            let formData = {
                address_line1: document.querySelector("[name='address_line1']").value,
                address_line2: document.querySelector("[name='address_line2']").value,
                city: document.querySelector("[name='city']").value,
                state: document.querySelector("[name='state']").value,
                zip: document.querySelector("[name='zip']").value
            };
            localStorage.setItem("postalAddress", JSON.stringify(formData));
            alert("Form data saved!");
        }
    </script>
    <style>
        body { background-color: #f8f9fa; height: 100vh; margin: 0; display: flex; }
        .container { display: flex; width: 100%; height: 100vh; }
        .sidebar {
            width: 300px; background: white; color: black; padding: 20px;
            border-right: 1px solid #ccc; height: 100vh; overflow-y: auto; flex-shrink: 0;
        }
        .sidebar h5 { font-weight: bold; }
        .sidebar p { font-size: 14px; color: #555; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li {
            padding: 12px; margin-bottom: 8px; border: 1px solid #ddd;
            border-radius: 5px; background: #f8f8f8; cursor: pointer;
            text-align: left; font-weight: bold;
        }
        .sidebar ul li.completed { background: #c8e6c9; border-color: #28a745; }
        .sidebar ul li.active { background: #d6eaff; border-color: #007bff; }
        .content { flex-grow: 1; display: flex; justify-content: center; align-items: center; padding: 0; margin: 0; }
        .card { width: 100%; max-width: 900px; padding: 40px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h5>Form Particulars</h5>
            <p>Click section to jump to the respective section</p>
            <ul>
                <li class="completed">1. Book Smartcard</li>
                <li class="active">2. Postal Address</li>
                <li>3. Payment</li>
                <li>4. Summary</li>
            </ul>
        </div>
        <div class="content">
            <div class="card">
                <h3>Enter Your Postal Address</h3>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success"><?= $message; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" name="address_line1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" name="address_line2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" name="zip" pattern="\d{5,6}" title="Enter a valid 5 or 6-digit ZIP code" required>
                    </div>
                    <button type="button" class="btn btn-secondary me-2" onclick="saveFormData()">Save & Continue Later</button>
                    <button type="submit" class="btn btn-primary">Next Step</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>