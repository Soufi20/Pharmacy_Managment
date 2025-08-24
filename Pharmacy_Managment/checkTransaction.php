<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $servername = "localhost";
$username = "root";
$password = "";
$database = "eph_dr_saadane";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT transaction_action FROM transaction WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $all_used_or_returned = true;
    $issued_found = false;

    while ($row = $result->fetch_assoc()) {
        if ($row['transaction_action'] != 'used' && $row['transaction_action'] != 'returned') {
            $all_used_or_returned = false;
        }
        if ($row['transaction_action'] == 'issued') {
            $issued_found = true;
            break;
        }
    }

   
    if ($all_used_or_returned) {
        $update_sql = "UPDATE transactionlist SET status = 'finished' WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $id);
        $update_stmt->execute();
        $update_stmt->close();
        echo "Transaction Finshed.";
    } elseif ($issued_found) {
        echo "Failed: A transaction is marked as 'issued'.";
    } else {
        echo "Failed: Some transactions are not marked as 'used'.";
    }
} else {
    echo "No ID provided.";
}
$stmt->close();
$conn->close();

?>
