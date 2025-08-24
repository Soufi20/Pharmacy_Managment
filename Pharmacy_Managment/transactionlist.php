<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "eph_dr_saadane";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
$sql = "SELECT * FROM prescription WHERE id = ?";
$stmt = $connection->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $connection->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetch the row
    $doctor = $row['doctor'];
    $name = $row['pname'];
    $status="in process";
    $currentTime = date('Y-m-d H:i:s');
    $insertSql = "INSERT INTO transactionlist (id, pname, doctor, status, timestamp) VALUES (?, ?, ?, ?, ?)";

    $insertStmt = $connection->prepare($insertSql);
    if (!$insertStmt) {
        die("Prepare failed: " . $connection->error);
    }
    $insertStmt->bind_param("issss", $id, $name, $doctor, $status, $currentTime);

    if ($insertStmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insertStmt->error;
    }
    
    $insertStmt->close();
} else {
    echo "No prescription found for the given ID.";
}
}
$stmt->close();
$connection->close();
?>
