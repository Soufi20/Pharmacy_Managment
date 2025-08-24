<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);
    $productBatch = mysqli_real_escape_string($conn, $_POST['productBatch']);
    $sci = mysqli_real_escape_string($conn, $_POST['sci']);
    $tradeName = mysqli_real_escape_string($conn, $_POST['tradeName']);
    $fabDate = mysqli_real_escape_string($conn, $_POST['fabDate']);
    $expDate = mysqli_real_escape_string($conn, $_POST['expDate']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $supplierId = mysqli_real_escape_string($conn, $_POST['supplierId']);
    $descreption1 = mysqli_real_escape_string($conn, $_POST['descreption']);
    $barcodeValue = $productId . "/" . $productBatch . "/" . $expDate;


    $insertMedicineSql = "INSERT INTO medicine (name) VALUES ('$tradeName')";
    $conn->query($insertMedicineSql);

    // Prepare and execute SQL query
    $sql = "INSERT INTO product (product_id, product_batch, product_description, product_sci_name, product_trade_name, product_fab_date, product_expiry_date, product_quantity, supplier_id, product_barcode, Current_Stock) VALUES ('$productId', '$productBatch', '$descreption1', '$sci', '$tradeName', '$fabDate', '$expDate', '$quantity', '$supplierId', '$barcodeValue', '$quantity')";
    
    // Insert data into the database
    if ($conn->query($sql) === TRUE) {
        // Barcode generation and display
        include 'barcode128.php';
        for ($i = 1; $i <= $quantity; $i++) {
            echo "<p class='inline'>" .  bar128($barcodeValue) . "</p>&nbsp&nbsp&nbsp&nbsp";   
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
<style>
p.inline {display: inline-block;}
span { font-size: 13px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>
</head>
<body onload="window.print(); setTimeout(function() { window.location.href = 'addmedicine.php'; }, 50);">
	<div style="margin-left: 5%">

	</div>
</body>
</html>
