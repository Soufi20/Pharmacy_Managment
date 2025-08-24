<?php

if (isset($_POST['ider']) && isset($_POST['scanInput'])) {
    $ider = $_POST['ider'];
    $scanInput = $_POST['scanInput'];
    $parts = explode('/', $scanInput);

    if(count($parts) != 3) {
        echo "Invalid scan input format";
        exit;
    }

    $productId = $parts[0];
    $productBatch = $parts[1];
    $expDate = $parts[2];

    // Include database configuration file
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

    // Prepare and bind the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM transaction WHERE ide = ?");
    $stmt->bind_param("i", $ider);
    $stmt->execute();

    // Execute the query
    $result = $stmt->get_result();

    // Check if a matching record was found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Compare productId and productBatch
        if ($row['product_id'] == $productId && $row['product_batch'] == $productBatch) {
            // Check if the current date is before the expDate
            $currentDate = new DateTime();
            $expirationDate = DateTime::createFromFormat('Y-m-d', $expDate);

            if ($currentDate < $expirationDate) {
                // Prepare the update statement
                $update_stmt = $conn->prepare("UPDATE transaction SET transaction_action = 'returned' WHERE ide = ?");
                $update_stmt->bind_param("i", $ider);

                // Execute the update statement
                if ($update_stmt->execute()) {
                    
        
                    // Now update the stock in the product table
                    $product_stmt = $conn->prepare("SELECT Current_Stock FROM product WHERE product_id = ? AND product_batch = ?");
                    $product_stmt->bind_param("is", $productId, $productBatch);
        
                    // Execute the select statement
                    if ($product_stmt->execute()) {
                        $result = $product_stmt->get_result();
                        if ($result->num_rows > 0) {
                            // Fetch the current stock
                            $product_row = $result->fetch_assoc();
                            $currentStock = $product_row['Current_Stock'];
        
                            // Increment the stock by 1
                            $newStock = $currentStock + 1;
        
                            // Prepare the update statement for the product table
                            $update_product_stmt = $conn->prepare("UPDATE product SET Current_Stock = ? WHERE product_id = ? AND product_batch = ?");
                            $update_product_stmt->bind_param("iis", $newStock, $productId, $productBatch);
        
                            // Execute the update statement
                            if ($update_product_stmt->execute()) {
                                echo "Stock updated successfully";
                            } else {
                                echo "Error updating stock: " . $conn->error;
                            }
                        } else {
                            echo "No matching product found";
                        }
                    
                } else {
                    echo "Error updating record: " . $conn->error;
                }

                $update_stmt->close();
            } else {
                echo "expaired";
                
            }
        } else {
            echo "Product ID or batch does not match";
        }
    } else {
        echo "No matching record found";
        echo "Product ID: " . $productId . "<br>";
        echo "Product Batch: " . $productBatch . "<br>";
        echo "Expiration Date: " . $expDate . "<br>";
        echo "id: " . $ider . "<br>";
    }

    // Close the prepared statement and the connection
    $stmt->close();
    $conn->close();
} else {
    echo "ID not set in the request";
}
}
?>
