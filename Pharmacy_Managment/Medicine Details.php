
<?php
session_start(); // Start the session

// Check if the user is not logged in and the cookie is set
$usernam=1;
if (!isset($_SESSION['username']) && isset($_COOKIE['user'])) {
    $_SESSION['username'] = $_COOKIE['user'];
    $usernam=$_COOKIE['user'];
}

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
        $pharmaName = $row["name"];
       
        // You can use $doctorName now
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="icon" type="image/png" href="fav1.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>medicine detailes</title>

    <!-- Montserrat Font -->
    <!-- Montserrat Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/css2.css" rel="stylesheet">

    <!-- Material Icons -->
    <link href="css/icon.css" rel="stylesheet">
    <script src="js/644d5fa036.js" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
   
    <!-- Custom CSS -->
    <style>
      .my-bg-primary {
            background-color: #0fac81; /* Primary background color */
            padding: 5px 10px; /* Padding */
            border-radius: 3px; /* Border radius */
            display: inline-block;
            font-family: Arial, sans-serif; /* Font family */
            color: #fff; /* Text color */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Box shadow */
            font-size: 0.8rem; /* Font size */
        }
    .checked {
  color:#FFD700;
}</style>
    
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
    <div class="notify">
    <div class="notify-btn" id="notify-btn">
    <audio id="notificationSound" src="2.mp3"></audio>

        <button type="button" class="icon-button dropdown-toggle">
            <span class="material-icons-outlined">notifications</span>
            <span class="icon-button_badge count" id="show_notif">0</span>
        </button>
    </div>
    <div class="notify-menu dropdown-menu" id="notify-menu"> 
        <ul class="sub">
            
        </ul>
    </div>
</div>

        
        <span class="material-icons-outlined" style="color: red; cursor: pointer;" onclick="logout()">logout</span>
    </div>
</header>

      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">
        <div class="sidebar-title">
          <div class="sidebar-brand">
            
             <?php echo '<h4><img src="b.png" alt="Pharmacy Icon" class="sidebar-icon" style="margin-top:-50px">Pharmacist ' . $pharmaName  . '</h4>'; ?>
          </div>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="index.php">
              <span class="material-icons-outlined">dashboard</span> Dashboard
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <i class="fa-solid fa-prescription-bottle-medical" style="font-size: 25px;"></i> Medicine
            </a>
            <ul class="subme">
              <li class="dropdown-item"><a href="addmedicine.php">Add Medicine</a></li>
              <li class="dropdown-item"><a href="medlist.php">Medicine List</a></li>
              <li class="dropdown-item"><a href="Medicine Details.php">Medicine Details</a></li>
            </ul>
          </li>
          
          
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <i class="fa-solid fa-truck" style="font-size: 25px;"></i>Manufacturer
            </a>
            <ul class="subme">
              <li class="dropdown-item"><a href="addsupp.php">Add Supplier</a></li>
              <li class="dropdown-item"><a href="supplaier.php">Supplier List</a></li>
            </ul>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
            <i class="fa-solid fa-file-medical" style="font-size: 30px"></i> Transaction
            </a>
            <ul class="subme">
              <li class="dropdown-item"><a href="pharmatranslist.php">Transaction List</a></li>
              <li class="dropdown-item"><a href="transaction.php">Transacton Details</a></li>
            </ul>
          </li>
          
          <li class="sidebar-list-item">
  <a href="pharmaacount.php?usernam=<?php echo urlencode($usernam); ?>" target="_blank">
    <span class="material-icons-outlined">settings</span> Account
  </a>
</li>

        </ul>
      </aside>
      <!-- End Sidebar -->

      <!-- Main -->
      <main class="main-container">
    <div class="main-title">
        <h2 >Medicine details</h2>
    </div>
    <form action="add.php" method="post">
        <div class="square"style="margin-top: 2%;">
            <div class="tabl">
                <h2 style="padding-left: 2%;margin-top: 2%;font-size:23px; font-family: 'ALSSchlangesans-Bold', Arial, sans-serif;">Medicine Information</h2>
                <table style="margin-top: 0%;" >
                    <thead>
                    <tr>
                                <th style='background-color: #f8f8f8; '>Scientific Name</th>
                                <th style='background-color: #f8f8f8; padding-left: 80px;'>Trade Name</th>
                                <th style='background-color: #f8f8f8; padding-left: 80px;'>Expire Date</th>
                                <th style='background-color: #f8f8f8; padding-left: 80px;'>Supplier ID</th>
                            </tr>
                    </thead>
                    <?php
// Check if product ID is provided in the URL
if(isset($_GET['productId']) && isset($_GET['batch'])) {
  // Get the product ID and batch from the URL
  $productId = $_GET['productId'];
  $batch = $_GET['batch'];
 
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

  // Prepare SQL query to fetch medicine details based on product ID and batch
  $sql = "SELECT * FROM product WHERE product_id = $productId AND product_batch = '$batch'";

    // Execute SQL query
    $result = $conn->query($sql);
    

    // Check if query returned any results
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Display medicine details
            echo "
   
        <thead>
            <tr>
                <td style='background-color: #f8f8f8;padding-left: 20px;'>" . $row["product_sci_name"] . "</td>
                <td style='background-color: #f8f8f8;padding-left: 100px;'>" . $row["product_trade_name"] . "</td>
                <td style='background-color: #f8f8f8;padding-left: 100px;'>" . $row["product_expiry_date"] . "</td>
                <td style='background-color: #f8f8f8;padding-left: 100px;'>";

    // Assuming $conn is your database connection
    $supplier_id = $row["supplier_id"];
    $query = "SELECT supplier_name FROM supplier WHERE supplier_id = $supplier_id";
    $supplier_result = mysqli_query($conn, $query);
    if ($supplier_result && mysqli_num_rows($supplier_result) > 0) {
        $supplier_row = mysqli_fetch_assoc($supplier_result);
        echo $supplier_row["supplier_name"];
    } else {
        echo "Supplier not found";
    }

    echo "
                </td>
            </tr>
        </thead>
    </table>";

if ($row["Popularity"] >= 1 && $row["Popularity"] <= 5) {
  echo "<h2 style='font-size: 16px;padding-left: 2%;margin-top:2%;'>Popularity</h2>
  <div style='padding-left: 2%;'>";

  for ($i = 1; $i <= 5; $i++) {
      if ($i <= $row["Popularity"]) {
          echo "<span class='fa fa-star checked'></span>";
      } else {
          echo "<span class='fa fa-star'></span>";
      }
  }
  echo "</div>";
} elseif ($row["Popularity"] == 0) {
  // Display 5 unchecked stars if Popularity is 0
  echo "<h2 style='font-size: 16px;padding-left: 2%;margin-top:2%;'>Popularity</h2>
  <div style='padding-left: 2%;'>";

  for ($i = 1; $i <= 5; $i++) {
      echo "<span class='fa fa-star'></span>";
  }

  echo "</div>";
}


        }
    } else {
        
    }

    // Close database connection
    $conn->close();
} else {
  $productId = 1;
  $batch =1;
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

  // Prepare SQL query to fetch medicine details based on product ID and batch
  $sql = "SELECT * FROM product WHERE product_id = $productId AND product_batch = '$batch'";

    // Execute SQL query
    $result = $conn->query($sql);
    

    // Check if query returned any results
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Display medicine details
            echo "
   
        <thead>
            <tr>
                <td style='background-color: #f8f8f8;padding-left: 20px;'>" . $row["product_sci_name"] . "</td>
                <td style='background-color: #f8f8f8;padding-left: 100px;'>" . $row["product_trade_name"] . "</td>
                <td style='background-color: #f8f8f8;padding-left: 100px;'>" . $row["product_expiry_date"] . "</td>
                <td style='background-color: #f8f8f8;padding-left: 100px;'>";

    // Assuming $conn is your database connection
    $supplier_id = $row["supplier_id"];
    $query = "SELECT supplier_name FROM supplier WHERE supplier_id = $supplier_id";
    $supplier_result = mysqli_query($conn, $query);
    if ($supplier_result && mysqli_num_rows($supplier_result) > 0) {
        $supplier_row = mysqli_fetch_assoc($supplier_result);
        echo $supplier_row["supplier_name"];
    } else {
        echo "Supplier not found";
    }

    echo "
                </td>
            </tr>
        </thead>
    </table>";

if ($row["Popularity"] >= 1 && $row["Popularity"] <= 5) {
  echo "<h2 style='font-size: 16px;padding-left: 2%;margin-top:2%;'>Popularity</h2>
  <div style='padding-left: 2%;'>";

  for ($i = 1; $i <= 5; $i++) {
      if ($i <= $row["Popularity"]) {
          echo "<span class='fa fa-star checked'></span>";
      } else {
          echo "<span class='fa fa-star'></span>";
      }
  }
  echo "</div>";
} elseif ($row["Popularity"] == 0) {
  // Display 5 unchecked stars if Popularity is 0
  echo "<h2 style='font-size: 16px;padding-left: 2%;margin-top:2%;'>Popularity</h2>
  <div style='padding-left: 2%;'>";

  for ($i = 1; $i <= 5; $i++) {
      echo "<span class='fa fa-star'></span>";
  }

  echo "</div>";
}


        }
    } else {
        
    }

    // Close database connection
    $conn->close();
}
?>
                
                <div style="border-top: 1px solid #ccc; margin-top: 10px;"></div>
                
                <div class="tabl">
                <h2 style="padding-left: 2%;margin-top: 2%;font-size:23px;">Stock</h2>
                <table style="margin-top: 0%;" >
                    <thead>
                    <tr>
                                <th style='background-color: #f8f8f8; '>Starting Stock</th>
                                <th style='background-color: #f8f8f8; padding-left: 70px;'>Current Stock</th>
                                <th style='background-color: #f8f8f8; padding-left: 70px;'>Stock Status</th>
                            </tr>
                    </thead>
                    <?php
// Check if product ID is provided in the URL
if(isset($_GET['productId']) && isset($_GET['batch'])) {
  // Get the product ID and batch from the URL
  $productId = $_GET['productId'];
  $batch = $_GET['batch'];
 
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

  // Prepare SQL query to fetch medicine details based on product ID and batch
  $sql = "SELECT * FROM product WHERE product_id = $productId AND product_batch = '$batch'";

    // Execute SQL query
    $result = $conn->query($sql);

    // Check if query returned any results
    if ($result->num_rows > 0) {
      // Output data of each row
      while($row = $result->fetch_assoc()) {
        $percentage = ($row["Current_Stock"] / $row["product_quantity"]) * 100;
        $percentage = number_format($percentage, 0);
        // Display medicine details
        echo "
                <thead>
                    <tr>
                        <td style='background-color: #f8f8f8;padding-left: 20px;margin-top: -2%;'>" . $row["product_quantity"] . "</td>
                        <td style='background-color: #f8f8f8;padding-left: 70px;'>" . $row["Current_Stock"] . "</td>
                        <td style='background-color: #f8f8f8;padding-left: 70px;'><span class='my-bg-primary'";
      
        if ($row["Current_Stock"] > 50) {
            echo " style='background-color:#0fac81;'>Available";
        } elseif ($row["Current_Stock"] > 0 && $row["Current_Stock"] < 50) {
            echo " style='background-color: orange;'>Low";
        } else {
            echo " style='background-color:red;'>Out of stock";
        }
      
        echo "</span></td>
                    </tr>
                </thead>
              </table>
              
              <div>
                <h2 style='font-size: 16px;padding-left: 2%;margin-top:2%;'>Remaining</h2>
                <div style='padding-left: 2%;'>
                  <div class='progress' style='width: 200px;'>
                    <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' style='width: $percentage%; background-color: #34ac88;'>
                    $percentage%
                    </div>
                  </div>
                </div>
              </div>";
    }
    
  } else {
      // No rows found in the result
  }
  
  // Close database connection
  $conn->close();
  } else {
      // If product ID is not provided in the URL
      $productId = 1;
  $batch =1;
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

  // Prepare SQL query to fetch medicine details based on product ID and batch
  $sql = "SELECT * FROM product WHERE product_id = $productId AND product_batch = '$batch'";

    // Execute SQL query
    $result = $conn->query($sql);

    // Check if query returned any results
    if ($result->num_rows > 0) {
      // Output data of each row
      while($row = $result->fetch_assoc()) {
        $percentage = ($row["Current_Stock"] / $row["product_quantity"]) * 100;
        $percentage = number_format($percentage, 0);
        // Display medicine details
        echo "
                <thead>
                    <tr>
                        <td style='background-color: #f8f8f8;padding-left: 20px;margin-top: -2%;'>" . $row["product_quantity"] . "</td>
                        <td style='background-color: #f8f8f8;padding-left: 70px;'>" . $row["Current_Stock"] . "</td>
                        <td style='background-color: #f8f8f8;padding-left: 70px;'><span class='my-bg-primary'";
      
        if ($row["Current_Stock"] > 50) {
            echo " style='background-color:#0fac81;'>Available";
        } elseif ($row["Current_Stock"] > 0 && $row["Current_Stock"] < 50) {
            echo " style='background-color: orange;'>Low";
        } else {
            echo " style='background-color:red;'>Out of stock";
        }
      
        echo "</span></td>
                    </tr>
                </thead>
              </table>
              
              <div>
                <h2 style='font-size: 16px;padding-left: 2%;margin-top:2%;'>Remaining</h2>
                <div style='padding-left: 2%;'>
                  <div class='progress' style='width: 200px;'>
                    <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' style='width: $percentage%; background-color: #34ac88;'>
                    $percentage%
                    </div>
                  </div>
                </div>
              </div>";
    }
    
  } else {
      // No rows found in the result
  }
  
  // Close database connection
  $conn->close();
 
  }
  
?>

              
                    
    </form>
</main>
</body>
</head>
</html>