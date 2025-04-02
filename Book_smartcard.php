<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['smartcard_booking'] = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'dob' => $_POST['dob'],
        'card_type' => $_POST['card_type'],
        'copies' => $_POST['copies'],
    ];
    
    // Handle file upload
    if (!empty($_FILES['id_proof']['name'])) {
        $upload_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES['id_proof']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['id_proof']['tmp_name'], $target_file)) {
            $_SESSION['smartcard_booking']['id_proof'] = $target_file;
        } else {
            $_SESSION['smartcard_booking']['id_proof'] = "Upload failed";
        }
    }

    header('Location: postal_address.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Card Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        .sidebar ul li.active { background: #d6eaff; border-color: #007bff; }
        .content { flex-grow: 1; display: flex; justify-content: center; align-items: flex-start; padding-top: 20px; margin-left: 0; }
        .card { width: 100%; max-width: 900px; padding: 40px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h5>Form Particulars</h5>
            <p>Click section to jump to the respective section</p>
            <ul>
                <li class="active">1. Book Smartcard</li>
                <li>2. Postal Address</li>
                <li>3. Payment</li>
                <li>4. Summary</li>
            </ul>
        </div>
        <div class="content">
            <div class="card">
                <h3>Book Your Smartcard</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="dob" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Smart Card Type</label>
                        <select class="form-control" name="card_type" required>
                            <option value="">Select Card Type</option>
                            <option value="Standard">Standard</option>
                            <option value="Premium">Premium</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Copies</label>
                        <input type="number" class="form-control" name="copies" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload ID Proof</label>
                        <input type="file" class="form-control" name="id_proof" accept="image/*,application/pdf" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Next Step</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
