<?php
session_start(); // Start the session
$usernam=1;
// Check if the user is not logged in and the cookie is set
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
$sql = "SELECT name, department FROM doctor WHERE id = '$usernam'";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Fetch the name and department from the result
        $doctorName = $row["name"];
        $doctorDepartment = $row["department"];
        
        // You can use $doctorName and $doctorDepartment now
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
// Assuming $doctorName holds the doctor's name
$sql_prescription = "SELECT COUNT(*) as total_rows FROM prescription WHERE doctor = '$doctorName'";
$result_prescription = $connection->query($sql_prescription);

if ($result_prescription) {
    // Fetch associative array
    $row_prescription = $result_prescription->fetch_assoc();
    $numpai = $row_prescription["total_rows"];
    // Output the result
}
// Assuming $doctorName holds the doctor's name



// Close connection
$connection->close();
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
    <title>Doctor Dashboard</title>

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
         <?php echo '<h4><img src="docim.png" alt="Pharmacy Icon" class="sidebar-icon" style="margin-top:-50px">Doctor ' . $doctorName  . '</h4>'; ?>

         </div>
         
       </div>

       <ul class="sidebar-list">
         <li class="sidebar-list-item">
           <a href="index2.php">
             <span class="material-icons-outlined">dashboard</span> Dashboard
           </a>
         </li>
         <li class="sidebar-list-item">
           <a href="addprescreption.php" >
           <i class='fas fa-file-prescription' style='font-size:25px'></i>  Add Prescription
           </a>
         </li>
        
         
         <li class="sidebar-list-item">
         
           <i class="fa-solid fa-file-medical" style="font-size: 25px"></i>
           <a href="tranlist.php">Transaction List</a></a>
         </li>
         <li class="sidebar-list-item">
         <i class="fa-solid fa-circle-info" style="font-size: 25px"></i>
           <a href="transactiondoctor.php">Transaction Details</a>
         </li>
         <li class="sidebar-list-item">
 <a href="doctoraccount.php?usernam=<?php echo urlencode($usernam); ?>" target="_blank">
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
              <h3>TRANSACTION</h3>
              <i class="fa-solid fa-arrows-spin"  style="font-size: 35px"></i>
            </div>
            <?php echo '<h1>' . $numpai . '</h1>'; ?>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3 style="font-size:20px">DEPERTMENT</h3>
              <i class="fa-regular fa-hospital" style="font-size: 35px"></i>
            </div>
            <?php echo '<h1>' . $doctorDepartment . '</h1>'; ?>
            
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>PAITENTS</h3>
              <span class="material-icons-outlined">groups</span>
            </div>
            <?php echo '<h1>' . $numpai . '</h1>'; ?>
          </div>

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
   
   
   <style>
    /* Container for the notification */
    .notify {
        position: relative;
        margin: 20px;
        display: inline-block;
     
    }

    /* Badge style */
    .icon-button_badge {
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 5px;
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 12px;
    }

    /* Notification menu style */
    .notify-menu {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        width: 300px;
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 5px;
        padding: 10px;
    }

    /* Notification menu list style */
    .notify-menu ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .notify-menu ul li {
        padding: 8px 0;
        border-bottom: 1px solid #ddd;
    }
    .icon-button {
    background: none;
    border: none;
    cursor: pointer;
    outline: none;
}

    .notify-menu ul li:last-child {
        border-bottom: none;
    }

    .notify-menu ul li a {
        text-decoration: none;
        color: #333;
    }

    .notify-menu ul li a:hover {
        color: #000;
        font-weight: bold;
    }

    /* Notification button style */
    .notify-btn {
        cursor: pointer;
    }

    /* Notification icon style */
    .material-icons-outlined.notification-icon {
        font-size: 24px;
        color: #333; /* Adjust the color as needed */
    }

   
</style>


<script>
$(document).ready(function(){
    var notificationSound = document.getElementById("notificationSound");

    function load_unseen_notification(view = '') {
        $.ajax({
            url:"docfetch.php",
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
</script>

  </head>
  </body>
</html>