<?php
session_start(); // Start the session

// Check if the user is not logged in and the cookie is set
$usernam="";
if (!isset($_SESSION['username']) && isset($_COOKIE['user'])) {
    $_SESSION['username'] = $_COOKIE['user'];
    $usernam = $_SESSION['username'];
}

// If the user is still not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); // Stop executing the script
}
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
$sql = "SELECT name FROM pharmacist WHERE id = '$usernam'";
  $result = $connection->query($sql);

  if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = $result->fetch_assoc()) {
          // Fetch the name from the result
          $doctorName = $row["name"];
         
          // You can use $doctorName now
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="fav1.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Doctor transaction</title>

    <!-- Montserrat Font -->
    <link href="css/css2.css" rel="stylesheet">

<!-- Material Icons -->
<link href="css/icon.css" rel="stylesheet">
<script src="js/644d5fa036.js" crossorigin="anonymous"></script>
<!-- Custom CSS -->
<link rel="stylesheet" href="css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Custom CSS -->
</head>
<body>
<div class="grid-container">
    <!-- Header -->
    <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
        
        </div>
        <div class="header-right">
          <span class="material-icons-outlined">notifications</span>
        
          <span class="material-icons-outlined" style="color: red; cursor: pointer;" onclick="logout()">logout</span>
        </div>
      </header>
      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">
        <div class="sidebar-title">
          <div class="sidebar-brand">
            <img src="docim.png" alt="Pharmacy Icon" class="sidebar-icon">
            <a>Doctor <?php echo  $doctorName ; ?></a>

          </div>
          
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="index2.php.html">
              <span class="material-icons-outlined">dashboard</span> Dashboard
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
            <i class='fas fa-file-prescription' style='font-size:25px'></i>  prescriptions
            </a>
            <ul class="subme">
              <li class="dropdown-item"><a href="addpresception.php"><i class="fa-solid fa-plus"></i>Add Prescription</a></li>
             
            </ul>
          </li>
         
          
          <li class="sidebar-list-item">
          
            <i class="fa-solid fa-file-medical" style="font-size: 25px"></i>
            <a href="tranlist.php">Transaction List</a></a>
          </li>
          <li class="sidebar-list-item">
          <i class="fa-solid fa-circle-info" style="font-size: 25px"></i>
            <a href="transactiondoctor">Transaction Details</a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <span class="material-icons-outlined">settings</span> Account
            </a>
          </li>

        </ul>
      </aside>
    <!-- End Sidebar -->

    <!-- Main -->
    <main class="main-container">
        <div class="main-title">
            <h2>Transaction</h2>
        </div>
        <div class="square">
            <section class="tabbod">
            <table class="table">
    <thead>
        <tr>
            <th style='background-color: #f8f8f8;'>Paitent name</th>
            <th style='background-color: #f8f8f8;'>medicine</th>
            <th style='background-color: #f8f8f8;'>Pharmacist</th>
            <th style='background-color: #f8f8f8;'>Doctor</th>
            <th style='background-color: #f8f8f8;'>Transaction Timestamp</th>
            <th style='background-color: #f8f8f8;'>Transaction Action</th>
            <th style='background-color: #f8f8f8;'>SCAN ME</th>
        </tr>
    </thead>
                    <tbody>
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
  
$id=22;
  
$sql = "SELECT * FROM transaction WHERE transaction_id = ?";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die('Error preparing the statement: ' . htmlspecialchars($conn->error));
}

// Bind the transaction ID parameter
$stmt->bind_param("i", $id);

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch and process the results
$r=1;
while ($r<5) {
  // Output table structure
  $r++;
  $med_id = $row['product_id'];
  $med_batch = $row['product_batch'];
  $stmt_product = $conn->prepare("SELECT product_trade_name FROM product WHERE product_id = ? AND product_batch = ?");
    $stmt_product->bind_param("is", $med_id, $med_batch);
    $stmt_product->execute();
    $stmt_product->bind_result($medicine_name);
    $stmt_product->fetch();
    $stmt_product->close();
  
  $quantity = $row['transaction_quantity'];
  if (!empty($medicine)) {
    for ($i=0; $i <4 ; $i++) { 
    
      echo "<tr>
      <td style='background-color: #f8f8f8;'>" . $row["pname"] . "</td>
      <td style='background-color: #f8f8f8;'>" . $medicine_name . "</td>
      <td style='background-color: #f8f8f8;'>" . $doctorName . "</td>
      <td style='background-color: #f8f8f8;'>" . $row["doctor"] . "</td>
      <td style='background-color: #f8f8f8;'>" . $row["transaction_timestamp"] . "</td>
      <td style='background-color: #f8f8f8;'>" . $row["transaction_action"] . "</td>
      <td style='background-color: #f8f8f8;'>
      <button class='scan-button' style='background-color: transparent; border: none;' onclick='scanFunction(\"$medicine\")'> 
          <i class=\"fas fa-barcode\" style='font-size:20px;'></i> 
      </button>
  </td>
    </tr>";
}
}
}

echo "
<div id='scanModalContainer' style='display: none;' class='modal'>
<div class='modal-content'>
    <span class='close'>&times;</span>
    <p id='scanInputLabel'>Scan Input:</p>
    <input type='text' id='scanInput' placeholder='Enter scan code'>
    <button id='submitScan'>Submit</button>
</div>
</div>
";

$stmt->close();
    $conn->close();

?>  
              
                    </tbody>
                </table>
            </section>
          
        </div>
        
<button class="beautiful-button">VALID</button>
    </main>
    <!-- End Main -->

    <!-- Scripts -->
    <!-- Bootstrap JS -->
    <script>
      function scanFunction(medicineName) {
    document.getElementById('scanInputLabel').innerText = 'Scan for ' + medicineName;
    document.getElementById('scanModalContainer').style.display = 'block';
}

    document.addEventListener('DOMContentLoaded', function() {
        var scanButtons = document.querySelectorAll('.scan-button');
        var scanModalContainer = document.getElementById('scanModalContainer');
        var closeModal = document.querySelector('.close');

        scanButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                scanModalContainer.style.display = 'flex'; // Change display to 'flex'
            });
        });

        closeModal.addEventListener('click', function() {
            scanModalContainer.style.display = 'none';
        });
    });
    document.getElementById('submitScan').addEventListener('click', function() {
    var scanInputLabel = document.getElementById('scanInputLabel').textContent;
    var scanInputValue = document.getElementById('scanInput').value;

    // Send data to PHP script via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'scan.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle successful response from PHP
                console.log(xhr.responseText);
            } else {
                // Handle error
                console.error('Error:', xhr.statusText);
            }
        }
    };
    xhr.send('scanInputLabel=' + encodeURIComponent(scanInputLabel) + '&scanInputValue=' + encodeURIComponent(scanInputValue));
});

</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <style>
      .scan-button:hover {
    color: red; 
      }
 /* Modal container */
 .modal {
    display: none;
    position: fixed;
    z-index: 1;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    width: 300px;
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

.modal-content p {
    font-size: 18px;
    margin-bottom: 10px;
}

.modal-content input {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.modal-content button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
}

.modal-content button:hover {
    background-color: #0056b3;
}

/* Styles for the beautiful button */
.beautiful-button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 20px; /* Adjusted padding */
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px; /* Smaller font size */
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 20px; /* Increased border radius for smoother edges */
  transition-duration: 0.4s;
  font-family: Arial, sans-serif; /* Change font family */
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
}

/* Hover effect */
.beautiful-button:hover {
  background-color: #45a049; /* Darker green */
}
      </style>
    <script>
      function logout() {
        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = "login.php";
        <?php session_destroy(); ?>
    }
  </script>
</div>
</body>
</html>
