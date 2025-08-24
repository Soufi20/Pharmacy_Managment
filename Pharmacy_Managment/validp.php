<?php
session_start(); 

$usernam=1;
if (!isset($_SESSION['username']) && isset($_COOKIE['user'])) {
    $_SESSION['username'] = $_COOKIE['user'];
    $usernam = $_SESSION['username'];

}


if (!isset($_SESSION['username'])) {
  
    header("Location: login.php");
    exit(); 
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
    if(isset($_GET['id'])) {
      $id = $_GET['id'];
    }
    

// Close database connection
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="fav1.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>validation</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Include jQuery UI library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 

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
<!-- Include jQuery UI library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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
          <h2>Validate Prescription</h2>
          
          
        </div>
      
        
        <div class="square">
        <section class="tabbod">
        <table class="table"  id="medicineTable">
        <thead>
       <tr>
        <th style='background-color: #f8f8f8;'>Patient name</th>
        <th style='background-color: #f8f8f8;'>Medicine</th>
        <th style='background-color: #f8f8f8;'>Quantity</th>
        <th style='background-color: #f8f8f8;'>Doctor</th>
        </tr>  
        <?php
// Database connection
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

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM prescription WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {
        $medicine = $row['medicine'];
        $quantity = $row['quantity'];
        $doctor = $row['doctor'];
        $name=$row['pname'];
        echo "<tr>";
        echo "<td contenteditable='true'>" . $row['pname'] . "</td>";
          echo "<td contenteditable='true'>" . $medicine . "</td>";
                echo "<td contenteditable='true'>" . $quantity . "</td>";
        echo "<td contenteditable='true'>" . $doctor . "</td>";
        echo "</tr>";

       }
    } else {
        echo "No prescription found for the given ID.";
    }
}

$connection->close();
?>

</table>
</section>
<form id="myForm" action="validprocess.php" method="POST" onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <div style="display: inline-block; float: left;">
        <button type="button"  class="btn" onclick="generetForm()">VALIDATE</button>
    </div>
    <div style="display: inline-block; float: right;">
        <button type="button" class="btn" onclick="cancelForm()">CANCEL</button>
    </div>
</form>



</div>
    </div>
    <style>
       
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table th, .table td {
            padding: 15px;
            text-align: left;
            vertical-align: top;
        }
        .table th {
            background-color: #f8f8f8;
        }
        .table tr:not(:first-child) {
            border-top: 1px solid #ddd;
        }
        .table td {
            background-color: #fff;
        }
    </style>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script>
      function generetForm() {
    var id = <?php echo json_encode($id); ?>;
    var username = <?php echo json_encode($usernam); ?>;
    
    // AJAX request to delete transactions
    // Send data to validprocess.php
$.ajax({
    type: "POST",
    url: "validprocess.php",
    data: { id: id, username: username },
    success: function(response) {
      
        // If the request is successful, perform another AJAX request to process.php
        $.ajax({
            type: "POST",
            url: "transactionlist.php",
            data: { id: id },
            success: function(response) {
              window.location.href = "index.php";
               
            },
            error: function(xhr, status, error) {
                // If there's an error in the request to process.php, display an alert
                alert("Error processing data: " + error); // Display error message
            }
        });
    },
    error: function(xhr, status, error) {
        // If there's an error in the request to validprocess.php, display an alert
        alert("Error validating data: " + error); // Display error message
    }
});

}
      function cancelForm() {
    
          window.location.href = "index.php";
      }
      $(document).ready(function() {
    // Make AJAX request to fetch medicine names
    $.ajax({
        url: 'fetmed.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Initialize autocomplete for medicine input fields
            $('.formcontact').autocomplete({
                source: response,
                minLength: 1 // Minimum characters before triggering autocomplete
            });
        }
    });
});
document.getElementById('myForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this);
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'transaction.php', true);
    window.location.href = "transaction.php";
    xhr1.send(formData);

    var xhr2 = new XMLHttpRequest();
    xhr2.open('POST', 'transactiondoctor.php', true);
    xhr2.send(formData);
});
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
     
    $(document).ready(function(){
            $('#myForm').on('submit', function(e){
                e.preventDefault(); // Prevent form submission
                var formData = $(this).serialize(); // Serialize form data

                // Send AJAX request
                $.ajax({
                    url: 'validp.php', // Replace with the path to your PHP script
                    method: 'POST',
                    data: formData,
                    success: function(response){
                        // Handle successful response
                        console.log(response);
                        // If you want to process the response further, you can do it here
                    },
                    error: function(xhr, status, error){
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            });
        });
      
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