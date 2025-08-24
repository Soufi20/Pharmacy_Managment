<?php
session_start(); // Start the session

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

// Query to count rows in the product table
$sql = "SELECT COUNT(*) as total_rows FROM product";

$result = $connection->query($sql);

if ($result) {
    // Fetch associative array
    $row = $result->fetch_assoc();
    $numpro=$row["total_rows"];
    // Output the result
}
$sql_prescription = "SELECT COUNT(*) as total_rows FROM prescription";
$result_prescription = $connection->query($sql_prescription);

if ($result_prescription) {
    // Fetch associative array
    $row_prescription = $result_prescription->fetch_assoc();
    $numpai=$row_prescription["total_rows"];
    // Output the result
  
}

// Close connection
$connection->close();
?>
<?php
$index=1;
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
// Fetch all products from the product table
$sql = "SELECT product_id, product_sci_name, product_trade_name, Current_Stock, product_expiry_date, product_batch FROM product";
$result = $conn->query($sql);

// Iterate through products and implement alert and medicine alert tables
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $givenDateTime = new DateTime($row["product_expiry_date"]);
      $currentDate = new DateTime();
      $availability = "";
      $statusClass = "";
      $exp = "";
      $prost = "";
      if ($index==1) {
          $deleteAlertStmt = $conn->prepare("DELETE FROM `alert`");
$deleteAlertStmt->execute();

// Delete all rows from the 'medicinealert' table
$deleteMedicineAlertStmt = $conn->prepare("DELETE FROM `medicinealert`");
$deleteMedicineAlertStmt->execute();
$index++;
      }

      if ($givenDateTime > $currentDate) {
          $interval = $currentDate->diff($givenDateTime);
          $daysUntilExpiry = $interval->days;
          $exp = "$daysUntilExpiry days";
          $prost = "less";

          if ($daysUntilExpiry == 5) {
              // Check if alert already exists
              $check_alert_stmt = $conn->prepare("SELECT * FROM `medicinealert` WHERE product_id = ? AND product_batch = ? AND alert_type = 'fivetodie'");
              $check_alert_stmt->bind_param("is", $row["product_id"], $row["product_batch"]);
              $check_alert_stmt->execute();
              $alert_result = $check_alert_stmt->get_result();

              if ($alert_result->num_rows == 0) {
                  // Insert into medicinealert table
                  $insert_alert_stmt = $conn->prepare("INSERT INTO `medicinealert` (product_id, product_batch, alert_type, timstamp) VALUES (?, ?, 'fivetodie', NOW())");
                  $insert_alert_stmt->bind_param("is", $row["product_id"], $row["product_batch"]);
                  $insert_alert_stmt->execute();
              }
          }
      }
      if ($row["Current_Stock"]==30) {
          $checkstmt = $conn->prepare("SELECT * FROM `medicinealert` WHERE product_id = ? AND product_batch = ? AND alert_type = 'less30'");
          $checkstmt->bind_param("is", $row["product_id"], $row["product_batch"]);
          $checkstmt->execute();
          $alert_result = $checkstmt->get_result();

          if ($alert_result->num_rows == 0) {
              // Insert into medicinealert table
              $insertstmt = $conn->prepare("INSERT INTO `medicinealert` (product_id, product_batch, alert_type, timstamp) VALUES (?, ?, 'less30', NOW())");
              $insertstmt->bind_param("is", $row["product_id"], $row["product_batch"]);
              $insertstmt->execute();
          }
          
      }
      

    }
}

// Close the database connection
$conn->close();
?>
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
$current_time = new DateTime();
$sql = "SELECT * FROM `transactionlist`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {

      $id = $row["id"];
      $alert_sql = "SELECT * FROM `alert` WHERE alert_id = '$id'";
      $alert_result = $conn->query($alert_sql);

      if ($alert_result->num_rows == 0) { // If the id does not exist in alert table
        $id = $row["id"];
        $alert_sql = "SELECT * FROM `alert` WHERE alert_id = '$id'";
        $alert_result = $conn->query($alert_sql);

        if ($alert_result->num_rows == 0) { // If the id does not exist in alert table
            $transaction_time = new DateTime($row["timestamp"]);
            $interval = $current_time->diff($transaction_time);
            $minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i; // Convert everything to minutes

            if ($minutes >= 64 && $row["status"] == "in process")
                // Insert into alert table
                $alert_sql = "INSERT INTO `alert` (alert_id, pname, alert_type) VALUES ('" . $row["id"] . "', '" . $row["pname"] . "', 'expired transaction')";
                $conn->query($alert_sql);
            }
        }
    }
  }
  $conn->close();
?>
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

// Get the count of alerts
$sql_alert_count = "SELECT COUNT(*) as count FROM `alert`";
$result_alert_count = $conn->query($sql_alert_count);
$row_alert_count = $result_alert_count->fetch_assoc();
$alert_count = $row_alert_count['count'];

// Get the count of medicine alerts
$sql_medicine_alert_count = "SELECT COUNT(*) as count FROM `medicinealert`";
$result_medicine_alert_count = $conn->query($sql_medicine_alert_count);
$row_medicine_alert_count = $result_medicine_alert_count->fetch_assoc();
$medicine_alert_count = $row_medicine_alert_count['count'];

$total_alerts = $alert_count + $medicine_alert_count;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="icon" type="image/png" href="fav1.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Pharmasist Dashboard</title>

    <!-- Montserrat Font -->
    <link href="css/css2.css" rel="stylesheet">

    <!-- Material Icons -->
    <link href="css/icon.css" rel="stylesheet">
    <script src="js/644d5fa036.js" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
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
        <h2>Dashboard</h2>
    </div>
   

    <div class="main-cards">
        <div class="card">
            <div class="card-inner">
                <h3>PRODUCTS</h3>
                <span class="material-icons-outlined">inventory_2</span>
            </div>
            <?php echo '<h1>' . $numpro . '</h1>'; ?>
        </div>


        <div class="card">
            <div class="card-inner">
                <h3>PAITENTS</h3>
               
                <span class="material-icons-outlined">groups</span>
            </div>
            <?php echo '<h1>' . $numpai . '</h1>'; ?>
        </div>

        <div class="card" onclick="location.href='get_alert.php'">
        <div class="card-inner">
            <h3>ALERTS</h3>
            <span class="material-icons-outlined">notification_important</span>
        </div>
        <h1 id="alertCount"><?php echo $total_alerts; ?></h1>
    </div>
        
        <!-- Classic Watch Card -->
        <div class="card">
            <div class="card-inner">
                <h3>ALGERIA</h3>
                <span class="material-icons-outlined">watch</span>
            </div>
            <h1 id="classic-watch">00:00:00</h1>
            <h2 id="current-date">YYYY-MM-DD</h2>
        </div>
    </div>

    
    </div>
</main>

      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script>
      function logout() {
        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = "login.php";
        <?php session_destroy(); ?>
    }
    
  </script>
   <script>
function updateTime() {
    const watchElement = document.getElementById('classic-watch');
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    watchElement.textContent = `${hours}:${minutes}:${seconds}`;
}

setInterval(updateTime, 1000);
updateTime();
function updateDateTime() {
    const now = new Date();

    // Update time
    const timeString = now.toLocaleTimeString('en-US', { hour12: false });
    document.getElementById('classic-watch').textContent = timeString;

    // Update date
    const dateString = now.toISOString().split('T')[0]; // YYYY-MM-DD format
    document.getElementById('current-date').textContent = dateString;
}

// Initial call to set the date and time immediately
updateDateTime();

// Update every second
setInterval(updateDateTime, 1000);
function playSound() {
            var audio = new Audio('2.mp3'); // Ensure you have the sound file in your directory
            audio.play();
        }

        // Function to fetch and update alert count
        function fetchAlertCount() {
            fetch('get_alert.php')
                .then(response => response.json())
                .then(data => {
                    let currentCount = parseInt(document.getElementById('alertCount').innerText);
                    if (data.total_alerts > currentCount) {
                        playSound();
                    }
                    document.getElementById('alertCount').innerText = data.total_alerts;
                });
        }

        // Fetch alert count every 10 seconds
        setInterval(fetchAlertCount, 10000); // initial call to display time immediately
</script>

   
   <style>
   .main-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #4CAF50;
    color: white;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin: 20px;
}

.main-title h2 {
    margin: 0;
    font-size: 24px;
}

.walking-paragraph-container {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    padding: 20px;
    background-color: #333; /* Background color */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow */
    text-align: center; /* Center text */
}

.walking-paragraph {
    display: inline-block;
    white-space: nowrap;
    font-size: 24px; /* Font size */
    color: red; /* Text color */
    font-family: 'LOTSOFDOTZ', sans-serif; /* Custom font */
    animation: walk 15s linear infinite; /* Animation */
}

@keyframes walk {
    0% {
        transform: translateX(100%);
    }
    50% {
        transform: translateX(0%);
    }
    100% {
        transform: translateX(100%);
    }
}


    /* Container for the notification */
    
</style>


<script>
$(document).ready(function(){
    var notificationSound = document.getElementById("notificationSound");

    function load_unseen_notification(view = '') {
        $.ajax({
            url:"fetch.php",
            method:"POST",
            data:{view:view},
            dataType:"json",
            success:function(data) {
                $('.notify-menu .sub').html(data.notification);
                if(data.unseen_notification > 0) {
                  notificationSound.play();
                    $('.count').html(data.unseen_notification);
                    document.title = "new notification"; 
    setTimeout(function() {
        document.title = "dashbord";
    }, 1000); 
                    
                }
            }
        });
    }

    load_unseen_notification();
    
    // Toggle visibility of the notification menu when the dropdown button is clicked
    $(document).on('click', '.dropdown-toggle', function(){
        $('.notify-menu').toggle();
        $('.count').html('');
        load_unseen_notification('yes');
    });
    
    setInterval(function(){
        load_unseen_notification();
    }, 5000);
});
</script>

  </head>
  </body>
</html>