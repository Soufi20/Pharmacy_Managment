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
    <title>Medicine list</title>

    <!-- Montserrat Font -->
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

    <header class="header">
    <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
    </div>
    <div class="header-left">
    <form id="searchForm" action="search.php" method="GET">
        <div id="searchInputWrapper">
            <input class="form-control mr-sm-2" id="searchInput" name="search" type="search" placeholder="Search By Name" aria-label="Search">
            <div id="searchResultsPopup"></div>
        </div>
    </form>
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
          <h2>Medicine</h2>
          </div>
          <div class="square">
    <section class="tabbod">
        <table class="table">
        <thead>
    <tr>
        <th style='background-color: #f8f8f8;'>Product ID</th>
        <th style='background-color: #f8f8f8;'>Scientific Name</th>
        <th style='background-color: #f8f8f8;'>Trade Name</th>
        <th style='background-color: #f8f8f8;'>Quantity</th>
        <th style='background-color: #f8f8f8;'>Supplier ID</th>
        <th style='background-color: #f8f8f8;'>StockStatus</th>
        <th style='background-color: #f8f8f8;'>ProductStatus</th>
        <th style='background-color: #f8f8f8;'>Details</th>
    </tr>
</thead>

            <tbody>
           
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

function getColorForStatus($statusClass) {
    switch ($statusClass) {
        case 'Available':
            return '#46d1ac';
        case 'Low':
            return '#f4c124';
        case 'Out-of-Stock':
            return 'red';
        default:
            return 'black';
    }
}

function getColorForproStatus($prost) {
    switch ($prost) {
        case 'less':
            return '#46d1ac';
        case 'tod':
            return '#f4c124';
        case 'exp':
            return 'red';
        default:
            return 'black';
    }
}

if (isset($_GET['delete'])) {
  delete($_GET['delete'], $_GET['batch']);
}

function delete($del, $batch) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $database);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $del = mysqli_real_escape_string($conn, $del);
  $batch = mysqli_real_escape_string($conn, $batch);
  $sql = "DELETE FROM product WHERE product_id = '$del' AND product_batch = '$batch'";
  if ($conn->query($sql) === TRUE) {
      
  } else {
      echo "Error deleting record: " . $conn->error;
  }
  $conn->close();
}

$rows_per_page = 9;
$sql_count = "SELECT COUNT(*) AS total FROM product";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_rows = $row_count['total'];
$total_pages = ceil($total_rows / $rows_per_page);
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $rows_per_page;
$sql = "SELECT product_id, product_sci_name, product_trade_name, product_quantity, supplier_id, product_expiry_date, product_batch, Current_Stock
        FROM product
        LIMIT $offset, $rows_per_page";
$result = $conn->query($sql);
?>


    <?php
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

                
            } elseif ($givenDateTime < $currentDate) {
                $exp = "Expired";
                $prost = "exp";
            } else {
                $exp = "Today";
                $prost = "tod";
            }

            if ($row["Current_Stock"] > 50) {
                $availability = "Available";
                $statusClass = "Available";
            }
            elseif ($row["Current_Stock"] <= 50 && $row["Current_Stock"] > 0) {
                $availability = "Low";
                $statusClass = "Low";
            } else {
                $availability = "Out of Stock";
                $statusClass = "Out-of-Stock";
            }
           
            

            echo "<tr>
                <td style='background-color: #f8f8f8;'>" . $row["product_id"] . "</td>
                <td style='background-color: #f8f8f8;'>" . $row["product_sci_name"] . "</td>
                <td style='background-color: #f8f8f8;'>" . $row["product_trade_name"] . "</td>
                <td style='background-color: #f8f8f8;'>" . $row["Current_Stock"] . "</td>
                <td style='background-color: #f8f8f8;'>" . $row["supplier_id"] . "</td>
                <td style='background-color: #f8f8f8; color: " . getColorForStatus($statusClass) . ";'>" . $availability . "</td>
                <td style='background-color: #f8f8f8; color: " . getColorForproStatus($prost) . ";'>" . $exp . "</td>
                <td class='dropdown' style='background-color: #f8f8f8;'>
                    <div class='split-button'>
                        <button class='split dropdown-toggle edit-button' data-product-id='" . $row["product_id"] . "'></button>
                        <ul class='dropdown-menu' id='dropdownMenu_" . $row["product_id"] . "'>
                        <li class='dropdown-item'><a href='edit.php' class='edit-link' data-product-id='" . $row["product_id"] . "'  data-product-batch='" . $row["product_batch"] . "'><i class='fa-regular fa-pen-to-square'></i> EDIT</a></li>


                            <li class='dropdown-iteme'><a href='?delete=" . $row["product_id"] . "&batch=" . $row["product_batch"] . "'><i class='fa-regular fa-trash-can'></i> Delete</a></li>
                            <li class='dropdown-iteme'><a href='Medicine Details.php' class='det-link' data-product-id='" . $row["product_id"] . "' data-batch='" . $row["product_batch"] . "'><i class='fa-solid fa-eye'></i> Medicine Details</a></li>
                        </ul>
                    </div>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>0 results</td></tr>";
    }
    ?>
    </tbody>
</table>

<div class='pagination'>
    <?php
    if ($current_page > 1) {
        echo "<a href='medlist.php?page=" . ($current_page - 1) . "' class='pagination-button'>Previous</a>";
    }

    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $current_page + 2);

    if ($start_page > 1) {
        echo "<a href='medlist.php?page=1' class='pagination-button'>1</a>";
        if ($start_page > 2) {
            echo "<span class='pagination-ellipsis'>...</span>";
        }
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            echo "<span class='pagination-button current'>$i</span>";
        } else {
            echo "<a href='medlist.php?page=$i' class='pagination-button'>$i</a>";
        }
    }

    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            echo "<span class='pagination-ellipsis'>...</span>";
        }
        echo "<a href='medlist.php?page=$total_pages' class='pagination-button'>$total_pages</a>";
    }

    if ($current_page < $total_pages) {
        echo "<a href='medlist.php?page=" . ($current_page + 1) . "' class='pagination-button'>Next</a>";
    }
    ?>
</div>

<?php
$conn->close();
?>

    </section>
   

              </div>
             

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
     
    // Initialize dropdown functionality for each split button
    $('.split-button').each(function () {
        var dropdownMenu = $(this).find('.dropdown-menu');
        var dropdownToggle = $(this).find('.dropdown-toggle');

        dropdownToggle.click(function () {
            dropdownMenu.toggleClass('show');
        });

        $(document).click(function (e) {
            if (!$(e.target).closest('.split-button').length) {
                dropdownMenu.removeClass('show');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    const editLinks = document.querySelectorAll('.edit-link');
    editLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const productBatch = this.getAttribute('data-product-batch');
            window.location.href = `edit.php?product_id=${productId}&product_batch=${productBatch}`;
        });
    });
});

    // Get references to the search icon and the search input wrapper


    document.addEventListener('DOMContentLoaded', function() {
        const editLinks = document.querySelectorAll('.det-link');
        editLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const productId = this.getAttribute('data-product-id');
                const batch = this.getAttribute('data-batch'); 
                window.location.href = `Medicine Details.php?productId=${productId}&batch=${batch}`;
            });
        });
    });
   
</script>
<script>
        document.querySelector('.form-control').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });
    </script>
<script>
      function logout() {
        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = "login.php";
        <?php session_destroy(); ?>
    }
  </script>
<style>
  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination-button {
    display: inline-block;
    padding: 10px 15px;
    margin: 0 5px;
    text-decoration: none;
    color: #007bff;
    border: 1px solid #007bff;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.pagination-button:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination-button.current {
    background-color: #007bff;
    color: #fff;
    pointer-events: none; /* Disable clicking on the current page */
}

.pagination-ellipsis {
    display: inline-block;
    padding: 10px 15px;
    margin: 0 5px;
    color: #6c757d;
}

  .material-icons-outlined {
        font-size: 24px; /* Adjust the size as needed */
        color: #333; /* Change the color to your preference */
        cursor: pointer; /* Add pointer cursor to indicate interactivity */
    }

    /* Style the search input */
    .form-control {
        padding: 8px 12px; /* Add some padding for better appearance */
        border-radius: 20px; /* Rounded corners for a modern look */
        border: 1px solid #ccc; /* Add a subtle border */
        transition: border-color 0.3s; /* Add transition for smoother effect */
        width: 200px; /* Adjust the width as needed */
    }

    /* Style the search input wrapper */
    #searchInputWrapper {
        display: inline-block; /* Ensure inline-block for proper alignment */
        vertical-align: middle; /* Align the input vertically */
        margin-left: 10px; /* Adjust the margin as needed */
    }

    /* Add hover effect to the search icon */
    .material-icons-outlined:hover {
        color: #666; /* Darken the color on hover */
    }

    /* Add focus style to the search input */
    .form-control:focus {
        border-color: #666; /* Change border color on focus */
        outline: none; /* Remove default outline */
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

  </body>
</html>