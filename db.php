
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$host = "srv1875.hstgr.io"; 
$username = "u949639822_lmr";  // Make sure this is correct
$password = "Laharimoniraghu@123";
$database = "u949639822_user_manage"; // Using the correct database

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
