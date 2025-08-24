<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "eph_dr_saadane";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if medicine parameter is set in POST request
if (isset($_POST['medicine'])) {
    $medicine = sanitize($_POST['medicine']);

    // Query to get the available quantity
    $sql = "SELECT Current_Stock FROM product WHERE product_trade_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $medicine);
    $stmt->execute();
    $stmt->bind_result($quantity);
    $stmt->fetch();
    $stmt->close();
    
    // Return the quantity
    echo $quantity;
}

// Close the database connection
$conn->close();

// Function to sanitize input
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}
?>
