<?php
session_start(); // Start the session

// Check if the user is not logged in and the cookie is set
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
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
<link rel="icon" type="image/png" href="fav1.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Transaction List</title>

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
            <h2>Transaction List</h2>
        </div>
        <div class="square">
            <section class="tabbod">
                <table class="table">
                    <thead>
                    <tr>
                    <th style='background-color: #f8f8f8;'>Transaction ID</th>
<th style='background-color: #f8f8f8;'>Paitent Name</th>

<th style='background-color: #f8f8f8;'>Pharmacist </th>
<th style='background-color: #f8f8f8;'>Doctor </th>
<th style='background-color: #f8f8f8;'>time creation</th>
<th style='background-color: #f8f8f8;'>Transaction status</th>
<th style='background-color: #f8f8f8;'>Details</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $na="Soufi oussama";
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
$sql = "SELECT * FROM `transactionlist`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["id"] . "</td>";
      echo "<td>" . $row["pname"] . "</td>";
      echo "<td>" . $na . "</td>";
      echo "<td>" . $row["doctor"] . "</td>";
      echo "<td>" . $row["timestamp"] . "</td>";
      echo "<td>" . $row["status"] . "</td>";
      echo "<td>";
      echo "<form action='transactiondoctor.php' method='get'>";
      echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
      echo "<button type='submit' class='details-button'>Details</button>";
      echo "</form>";
      echo "</td>";
      echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No results found</td></tr>";
}

// Close connection
$conn->close();
?>

                
                    </tbody>
                </table>
            </section>
        </div>
    </main>
    <!-- End Main -->
   
    <!-- Scripts -->
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    .details-button {
        position: relative;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        padding: 0.3rem 1rem; /* Adjusted padding for smaller size */
        background-color: rgb(0 107 179);
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #ffff;
        gap: 5px; /* Reduced gap */
        font-weight: bold;
        border: 3px solid #ffffff4d;
        outline: none;
        overflow: hidden;
        font-size: 12px; /* Adjusted font size */
    }

    .icon {
        width: 20px; /* Adjusted icon size */
        height: 20px; /* Adjusted icon size */
        transition: all 0.3s ease-in-out;
    }

    .details-button:hover {
        transform: scale(1.05);
        border-color: #fff9;
    }

    .details-button:hover .icon {
        transform: translate(2px); /* Adjusted icon translation */
    }

    .details-button:hover::before {
        animation: shine 1.5s ease-out infinite;
    }

    .details-button::before {
        content: "";
        position: absolute;
        width: 100px;
        height: 100%;
        background-image: linear-gradient(
            120deg,
            rgba(255, 255, 255, 0) 30%,
            rgba(255, 255, 255, 0.8),
            rgba(255, 255, 255, 0) 70%
        );
        top: 0;
        left: -100px;
        opacity: 0.6;
    }

    @keyframes shine {
        0% {
            left: -100px;
        }

        60% {
            left: 100%;
        }

        to {
            left: 100%;
        }
    }
</style>

    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script>
      function logout() {
        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = "login.php";
        <?php session_destroy(); ?>
    }
    function toggleNotification() {
  var table = document.getElementById("notificationTable");
  if (table.style.display === "none") {
    table.style.display = "block";
  } else {
    table.style.display = "none";
  }
}
  </script>
</div>
</body>
</html>
