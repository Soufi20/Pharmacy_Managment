<?php
// Database connection
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

// Query to fetch medicine names
$sql = "SELECT name FROM medicine";
$result = $conn->query($sql);

$medicineNames = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $medicineNames[] = $row['name'];
    }
}

// Close the database connection
$conn->close();

// Return medicine names as JSON
echo json_encode($medicineNames);
?>
