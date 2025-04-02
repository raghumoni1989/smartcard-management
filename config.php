<?php
// Razorpay API Configuration

define('RAZORPAY_KEY_ID', 'rzp_live_v66eSDRBoYDQtD');
define('RAZORPAY_KEY_SECRET', 'J3vxvvsuqDVq3tqFEFKKmpqs');

// Database Configuration
define('DB_HOST', 'srv1875.hstgr.io');
define('DB_USER', 'u949639822_lmr');
define('DB_PASS', 'Laharimoniraghu@123');
define('DB_NAME', 'u949639822_user_manage');

// Start Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start PHP session
session_start();
