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
    <title>Alert list</title>

    <!-- Montserrat Font -->
    <link href="css/css2.css" rel="stylesheet">

<!-- Material Icons -->
<link href="css/icon.css" rel="stylesheet">
<script src="js/644d5fa036.js" crossorigin="anonymous"></script>
<!-- Custom CSS -->
<link rel="stylesheet" href="css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <h2>Alert List</h2>
        </div>
        <div class="square">
            <section class="tabbod">
                <table class="table">
                    <thead>
                    <tr>
                        <th style='background-color: #f8f8f8;'>Id</th>
                        <th style='background-color: #f8f8f8;'>Paitent Name</th>
                        <th style='background-color: #f8f8f8;'>Alert Type</th>
                        <th style='background-color: #f8f8f8;'>details</th>
                        
                        
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

                    $rows_per_page = 7;
                    $sql_count = "SELECT COUNT(*) AS total FROM supplier";
                    $result_count = $conn->query($sql_count);
                    $row_count = $result_count->fetch_assoc();
                    $total_rows = $row_count['total'];
                    $total_pages = ceil($total_rows / $rows_per_page);
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $rows_per_page;

                    $sql = "SELECT alert_id, pname, alert_type FROM alert LIMIT $offset, $rows_per_page";

                    // Execute the SQL query
                    $result = $conn->query($sql);
                    
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            // Output each row data as table rows
                            echo "<tr>
                            <td style='background-color: #f8f8f8;'>" . $row["alert_id"] . "</td>
                            <td style='background-color: #f8f8f8;'>" . $row["pname"] . "</td>
                            <td style='background-color: #f8f8f8;'>" . $row["alert_type"] . "</td>
                            <td style='background-color: #f8f8f8;'>
                                <form action='transaction.php' method='get'>
                                    <input type='hidden' name='id' value='" . $row["alert_id"] . "'>
                                    <button type='submit' class='details-button'>Details</button>
                                </form>
                            </td>
                        </tr>";
                        
                        }
                    } else {
                        
                    }
                    $sql = "SELECT ma.id, p.product_id, p.product_trade_name, ma.product_batch, ma.alert_type 
                    FROM medicinealert AS ma
                    INNER JOIN product AS p ON ma.product_id = p.product_id
                    WHERE ma.product_id = ma.product_id AND ma.product_batch = ma.product_batch
                    LIMIT $offset, $rows_per_page";
            

            // Execute the SQL query
            $result = $conn->query($sql);
            
            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    // Output each row data as table rows
                    echo "<tr>
                            <td style='background-color: #f8f8f8;'>" . $row["id"] . "</td>
                            <td style='background-color: #f8f8f8;'>" . $row["product_trade_name"] . "</td>
                            <td style='background-color: #f8f8f8;'>" . $row["alert_type"] . "</td>
                            <td style='background-color: #f8f8f8;'>
                <form action='edit.php' method='get'>
                    <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>
                    <input type='hidden' name='product_batch' value='" . $row["product_batch"] . "'>
                    <button type='submit' class='details-button'>Details</button>
                </form>
            </td>
                          </tr>";
                }
            } else {
               
            }
            

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
</div>
</body>
</html>
