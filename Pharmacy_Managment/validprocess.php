<?php
$index=1;
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

if (isset($_POST['id'], $_POST['username'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $sql = "SELECT * FROM prescription WHERE id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $connection->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
            $medicine = $row['medicine'];
            $quantity = $row['quantity'];
            $doctor = $row['doctor'];
            $name = $row['pname'];
            if ($index==1) {
                $status="in process";
                $insertSql = "INSERT INTO transactionlist (id, pname, doctor, status) VALUES (?, ?, ?, ?)";
                
                $insertStmt = $connection->prepare($insertSql);
                if (!$insertStmt) {
                    die("Prepare failed: " . $connection->error);
                }
                $insertStmt->bind_param("isss", $id, $name, $doctor, $status);
                
                if ($insertStmt->execute()) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $insertStmt->error;
                }
                
                $insertStmt->close();
                $index++;
            }

            $product_sql = "SELECT * FROM product WHERE product_trade_name = ?";
            $product_stmt = $connection->prepare($product_sql);
            if (!$product_stmt) {
                die("Prepare failed: " . $connection->error);
            }
            $product_stmt->bind_param("s", $medicine);
            $product_stmt->execute();
            $product_result = $product_stmt->get_result();

            if ($product_result->num_rows > 0) {
                $product_row = $product_result->fetch_assoc();
                $product_id = $product_row['product_id'];
                $product_batch = $product_row['product_batch'];
                $current_stock = $product_row['Current_Stock']; // Assuming 'product_quantity' is the column representing current stock

                // Subtract the quantity sold from the current stock
                $new_stock = ($current_stock - $quantity);
            
                // Prepare and execute an SQL update statement to update the current stock
                $update_sql = "UPDATE product SET Current_Stock = ? WHERE product_id = ? AND product_batch = ?";
          $update_stmt = $connection->prepare($update_sql);
         if (!$update_stmt) {
        die("Prepare failed: " . $connection->error);
     }
      $update_stmt->bind_param("iis", $new_stock, $product_id, $product_batch);
      $update_stmt->execute();
      $update_stmt->close();

                $doctor_sql = "SELECT id FROM doctor WHERE name = ?";
                $doctor_stmt = $connection->prepare($doctor_sql);
                if (!$doctor_stmt) {
                    die("Prepare failed: " . $connection->error);
                }
                $doctor_stmt->bind_param("s", $doctor);
                $doctor_stmt->execute();
                $doctor_result = $doctor_stmt->get_result();

                if ($doctor_result->num_rows > 0) {
                    $doctor_row = $doctor_result->fetch_assoc();
                    $doctor_id = $doctor_row['id'];

                    // Assuming $usernam is defined elsewhere in your actual code
                     // Example placeholder, replace with actual logic
                    for($i=0;$i<$quantity;$i++){
                    $transaction_sql = "INSERT INTO transaction (transaction_id, product_id, product_batch, pharmacist_id, doctor_id, transaction_quantity, transaction_timestamp, transaction_action, pname) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW(), 'issued', ?)";
                    $transaction_stmt = $connection->prepare($transaction_sql);
                    if (!$transaction_stmt) {
                        die("Prepare failed: " . $connection->error);
                    }
                    $transaction_stmt->bind_param("iisiiis", $id, $product_id, $product_batch, $username, $doctor_id, $quantity, $name);
                    if (!$transaction_stmt->execute()) {
                        echo "Error: " . $transaction_stmt->error;
                    } else {
                        echo "Transaction successful!";
                    }
                }

               
                } else {
                    echo "No doctor found for the given doctor name.";
                }
            } else {
                echo "No product found for the given medicine.";
            }
        
    }
    } else {
        echo "No prescription found for the given ID.";
    }
}

$connection->close();
?>