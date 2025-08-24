<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "eph_dr_saadane";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_GET['product_id']) && isset($_GET['product_batch'])) {
    
    $product_id = $_GET['product_id'];
$product_batch = $_GET['product_batch'];

    // Assuming you have a database connection object named $conn
    $sql = "SELECT * FROM product WHERE product_id = $product_id AND product_batch = '$product_batch'";

    // Execute SQL query
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Fetch the product details
        $product = $result->fetch_assoc();
        // Do something with the product data
    } else {
        echo "No product found with ID: $product_id and batch: $product_batch";
    }
}


$conn->close();
?>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "eph_dr_saadane";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $productId = $_POST['productId'];
    $productBatch = $_POST['productBatch'];
    $sci = $_POST['sci'];
    $tradeName = $_POST['tradeName'];
    $fabDate = $_POST['fabDate'];
    $expDate = $_POST['expDate'];
    $quantity = $_POST['quantity'];
    $barecode = $_POST['barecode'];
    $supplierId = $_POST['supplierId'];
    $description = $_POST['descreption'];

    
    $sql = "UPDATE product SET 
            product_sci_name = '$sci', 
            product_trade_name = '$tradeName', 
            product_fab_date = '$fabDate', 
            product_expiry_date = '$expDate', 
            product_quantity = '$quantity', 
            product_barcode = '$barecode', 
            supplier_id = '$supplierId', 
            product_description = '$description',
            Current_Stock= '$quantity'
        WHERE product_id = $productId AND product_batch = '$productBatch'";


    
if ($conn->query($sql) === TRUE) {
    
    echo "<script>window.location.href = 'medlist.php';</script>";
    exit;
} else {
    echo "Error updating product information: " . $conn->error;
}
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Edit Medicine</title>
     <!-- Montserrat Font -->
     <link href="css/css2.css" rel="stylesheet">

<!-- Material Icons -->
<link href="css/icon.css" rel="stylesheet">
<script src="js/644d5fa036.js" crossorigin="anonymous"></script>
<!-- Custom CSS -->
<link rel="stylesheet" href="css/styles.css">
    <style>
        .grid-container1 {
          display: grid;
          grid-template-columns: auto; 
        }
  
        .header1 {
          grid-column: 1;
         
        }
  
        .main-container1 {
          grid-column: 1;
          padding: 20px; 
        }
  
        .square1 {
          width: calc(100% - 40px); 
          height: calc(100vh - 60px); 
          border: 0.1px solid #c5e0f8;
          border-radius: 10px;
          padding: 20px; 
          margin: 20px; 
        }
    </style>
</head>
<body>
    <div class="grid-container1">
        <main class="main-container1">
            <div class="main-title">
                <h2>Edit Medicine</h2>
            </div>
            <form action="edit.php" method="post">
                <div class="square1">
                    <div class="row3">
                        <div class="form-wrapper">
                            <label class="formlab" for="prodid">Product ID</label>
                            <input type="text" name="productId" id="prodid" placeholder="Product ID" class="formcontact" value="<?php echo isset($product['product_id']) ? $product['product_id'] : ''; ?>" readonly>
                        </div>
                        <div class="form-wrapper">
                            <label class="formlab" for="batch">Product Batch</label>
                            <input type="text" name="productBatch" id="batch" placeholder="Product Batch" class="formcontact" value="<?php echo isset($product['product_batch']) ? $product['product_batch'] : ''; ?>">
                        </div>
                        <div class="form-wrapper">
                            <label class="formlab" for="sci">SCI</label>
                            <input type="text" name="sci" id="sci" placeholder="SCI" class="formcontact" value="<?php echo isset($product['product_sci_name']) ? $product['product_sci_name'] : ''; ?>">
                        </div>
                    </div>
                    <div class="row2">
                  <div class="form-wrapper">
                      <label class="formlab" for="Trade-Name">Trade-Name</label>
                      <input type="text" name="tradeName" id="trade" placeholder="Trade-Name" class="formcontact" value="<?php echo isset($product['product_trade_name']) ? $product['product_trade_name'] : ''; ?>">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="fab_date">fab_date</label>
                      <input type="date" name="fabDate" id="fabdate" class="formcontact" value="<?php echo isset($product['product_fab_date']) ? $product['product_fab_date'] : ''; ?>">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="exp_date">exp_date</label>
                      <input type="date" name="expDate" id="expdate" class="formcontact" value="<?php echo isset($product['product_expiry_date']) ? $product['product_expiry_date'] : ''; ?>">
                  </div>
                 
              </div>
              <div class="row1">
                  <div class="form-wrapper">
                      <label class="formlab" for="Quantity">Quantity</label>
                      <input type="number" name="quantity" id="quantity" class="formcontact" value="<?php echo isset($product['product_quantity']) ? $product['product_quantity'] : ''; ?>">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="Barecode">Barcode</label>
                      <input type="text" name="barecode" id="barecode" placeholder="Barcode" class="formcontact" value="<?php echo isset($product['product_barcode']) ? $product['product_barcode'] : ''; ?>">

                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="Supplier-Id">Supplier-Id</label>
                      <input type="number" name="supplierId" id="supid" class="formcontact" value="<?php echo isset($product['supplier_id']) ? $product['supplier_id'] : ''; ?>">
                  </div>
              </div>
              <div class="form-wrapper">
    <label class="formlab" for="descreption">Description</label>
    <textarea name="descreption" id="descreption" class="formdes"><?php echo isset($product['product_description']) ? $product['product_description'] : ''; ?></textarea>
</div>

            
                   
                    <div>
                        <button type="submit" class="btn">Update Medicine</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
