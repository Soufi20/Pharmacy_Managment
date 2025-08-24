<?php
session_start(); 

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
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="fav1.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Add medicine</title>

    <!-- Montserrat Font -->
     <!-- Montserrat Font -->
     <link href="css/css2.css" rel="stylesheet">

<!-- Material Icons -->
<link href="css/icon.css" rel="stylesheet">
<script src="js/644d5fa036.js" crossorigin="anonymous"></script>
<!-- Custom CSS -->
<link rel="stylesheet" href="css/styles.css">
    <script src="js/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
          <h2>Add Medicine</h2>
          
        </div>
        <form action="barcode.php" method="post" id="addMedicineForm" >
          <div class="square">
              <div class="row3">
                  <div class="form-wrapper">
                      <label class="formlab" for="product_id">Product-Id</label>
                      <input type="text" name="productId" id="prodid" placeholder="product_id" class="formcontact">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="product_batch">Product-Batch</label>
                      <input type="text" name="productBatch" id="batch" placeholder="product_batch" class="formcontact">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="SCI">SCI</label>
                      <input type="text" name="sci" id="sci" placeholder="SCI" class="formcontact">
                  </div>
              </div>
              <div class="row2">
                  <div class="form-wrapper">
                      <label class="formlab" for="Trade-Name">Trade-Name</label>
                      <input type="text" name="tradeName" id="trade" placeholder="Trade-Name" class="formcontact">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="fab_date">fab_date</label>
                      <input type="date" name="fabDate" id="fabdate" class="formcontact">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="exp_date">exp_date</label>
                      <input type="date" name="expDate" id="expdate" class="formcontact">
                  </div>
                 
              </div>
              <div class="row1">
                  <div class="form-wrapper">
                      <label class="formlab" for="Quantity">Quantity</label>
                      <input type="number" name="quantity" id="quantity" class="formcontact">
                  </div>
                  <div class="form-wrapper">
                      <label class="formlab" for="Supplier-Id">Supplier-Id</label>
                      <input type="number" name="supplierId" id="supid" class="formcontact">
                  </div>
              </div>
              <div class="form-wrapper">
                <label class="formlab" for="descreption">Description</label>
                <textarea name="descreption" id="descreption" class="formdes"></textarea>
            </div>
            
              <div>
              <button type="submit" class="btn" >Add Medicine and Generate Barcode</button>
        </div>
              </div>
          </div>
      </form>
      
        

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the form element
            var form = document.querySelector("form");

            // Add event listener for keydown event on the form
            form.addEventListener("keydown", function(event) {
                // Check if the pressed key is Enter
                if (event.key === "Enter") {
                    // Prevent the default form submission behavior
                    event.preventDefault();
                }
            });
        });
       
  
            
    function logout() {
        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = "login.php";
        <?php session_destroy(); ?>
    }  
        
    </script>
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
</body>
</html>