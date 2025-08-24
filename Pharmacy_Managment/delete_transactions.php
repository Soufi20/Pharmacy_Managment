<?php
// Include database connection code
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

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Prepare SQL statement to delete rows from transaction table
    $delete_sql = "DELETE FROM transaction WHERE transaction_id = ?";
    $delete_stmt = $connection->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id);
    
    // Execute the delete statement
    if ($delete_stmt->execute()) {
        
    } else {
        echo "Error deleting transactions: " . $connection->error;
    }
} else {
    echo "No ID provided.";
}

// Close database connection
$connection->close();
?>
