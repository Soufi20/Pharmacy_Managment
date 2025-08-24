<?php
session_start(); // Start the session

// Check if the user is not logged in and the cookie is set
$usernam = 1;
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
            <h2>Transaction</h2>
        </div>
        <div class="square">
            <section class="tabbod">
                <table class="table">
                    <thead>
                        <tr>
                            <th style='background-color: #f8f8f8;'>Patient name</th>
                            <th style='background-color: #f8f8f8;'>Medicine</th>
                            <th style='background-color: #f8f8f8;'>Pharmacist</th>
                            <th style='background-color: #f8f8f8;'>Doctor</th>
                            <th style='background-color: #f8f8f8;'>Transaction Timestamp</th>
                            <th style='background-color: #f8f8f8;'>Transaction Action</th>
                            <th style='background-color: #f8f8f8;'>SCAN ME</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $id="";
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                    }else {
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
                        $sql = "SELECT transaction_id FROM transaction ORDER BY transaction_id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['transaction_id'];
    } else {
        $id = null; // or handle the case where there are no transactions
    }
                    }
                        $conn = new mysqli($servername, $username, $password, $database);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT * FROM transaction WHERE transaction_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $med_id = $row['product_id'];
                            $med_batch = $row['product_batch'];
                            $doctor_id = $row['doctor_id'];
                            $pharma_id = $row['pharmacist_id'];
                            $stmt_doctor = $conn->prepare("SELECT name FROM doctor WHERE id = ?");
                            $stmt_doctor->bind_param("i", $doctor_id);
                            $stmt_doctor->execute();
                            $stmt_doctor->bind_result($doctor_name);
                            $stmt_doctor->fetch();
                            $stmt_doctor->close();
                            $stmt_pharma = $conn->prepare("SELECT name FROM pharmacist WHERE id = ?");
                            $stmt_pharma->bind_param("i", $pharma_id);
                            $stmt_pharma->execute();
                            $stmt_pharma->bind_result($pharma_name);
                            $stmt_pharma->fetch();
                            $stmt_pharma->close();
                            $stmt_product = $conn->prepare("SELECT product_trade_name FROM product WHERE product_id = ? AND product_batch = ?");
                            $stmt_product->bind_param("is", $med_id, $med_batch);
                            $stmt_product->execute();
                            $stmt_product->bind_result($medicine_name);
                            $stmt_product->fetch();
                            $stmt_product->close();
                            $quantity = $row['transaction_quantity'];
                            if (!empty($medicine_name)) {
                                $ider = $row['ide'];
                                echo "<tr>
                                        <td style='background-color: #f8f8f8;'>" . htmlspecialchars($row["pname"]) . "</td>
                                        <td style='background-color: #f8f8f8;'>" . htmlspecialchars($medicine_name) . "</td>
                                        <td style='background-color: #f8f8f8;'>" . htmlspecialchars($pharma_name) . "</td>
                                        <td style='background-color: #f8f8f8;'>" . htmlspecialchars($doctor_name) . "</td>
                                        <td style='background-color: #f8f8f8;'>" . htmlspecialchars($row["transaction_timestamp"]) . "</td>
                                        <td style='background-color: #f8f8f8;'>" . htmlspecialchars($row["transaction_action"]) . "</td>
                                        <td style='background-color: #f8f8f8;'>
            <button class='scan-button' data-ider='" . htmlspecialchars($ider) . "' style='background-color: transparent; border: none;'>
                <i class='fas fa-barcode' style='font-size:20px;'></i>
            </button>
        </td>
                                      </tr>";
                            }
                        }
                        $stmt->close();
                        $conn->close();
                        echo"<div id='scanModalContainer' style='display: none;' class='modal'>
                        <div class='modal-content'>
                            <span class='close'>&times;</span>
                            <p id='scanInputLabel'>Scan Input:</p>
                            <input type='text' id='scanInput' placeholder='Enter scan code'>
                            <button id='submitScan'>Submit</button>
                        </div>
                    </div>";
                    
                    
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script>
         $(document).ready(function() {
            $('.beautiful-button').click(function() {
                var id = "<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>";
                if (id) {
                    $.ajax({
                        url: 'checkTransaction.php',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            alert(response);
                            window.location.href = "index2.php";
                        },
                        error: function() {
                            alert('Error validating transaction.');
                        }
                    });
                } else {
                    alert('No ID provided.');
                }
            });
        });
        function logout() {
            document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            window.location.href = "login.php";
            <?php session_destroy(); ?>
        }

     
        $(document).ready(function() {
    var ider;

    $('.scan-button').on('click', function() {
        ider = $(this).data('ider');
        $('#scanModalContainer').show();
    });

    $('.close').on('click', function() {
        $('#scanModalContainer').hide();
    });

    $('#submitScan').on('click', function() {
        var scanInputValue = $('#scanInput').val();

        if (scanInputValue.trim() === '') {
            alert('Please enter a scan code.');
            return;
        }

        $.ajax({
            type: "POST",
            url: "scanprocees.php",
            data: { ider: ider, scanInput: scanInputValue },
            success: function(response) {
                
                $('#scanModalContainer').hide();
                window.location.reload(); 
                $("#myButton").css("visibility", "visible");
                
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
});
document.getElementById('scanInput').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent form submission if this input is inside a form
        document.getElementById('submitScan').click();
    }
});

document.getElementById('submitScan').addEventListener('click', function() {
    var scanCode = document.getElementById('scanInput').value;
    
    console.log('Scan code submitted: ' + scanCode); // For demonstration purposes
});


    </script>
    
    <style>
       
        .scan-button:hover {
            color: red;
        }
        tr.highlight {
            background-color: #d3d3d3; /* Highlight color */
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
        .close:hover, .close:focus {
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
            background-color: #4CAF50;
             /* Green */
             
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
    </script>
</div>
</body>
</html>
