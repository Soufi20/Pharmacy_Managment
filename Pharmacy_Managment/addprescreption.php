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
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT name FROM doctor WHERE id = '$usernam'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = $result->fetch_assoc()) {
          // Fetch the name from the result
          $doctorName = $row["name"];
         
          // You can use $doctorName now
      }
    }
    function sanitize($input) {
      return htmlspecialchars(strip_tags(trim($input)));
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve form data
      $patient_name = sanitize($_POST['Patient_name']);
      $age = sanitize($_POST['Age']);
      $gender = sanitize($_POST['Gender']);
    
      $medicines = array();
      $quantities = array();
      for ($i = 1; $i <= 12; $i++) {
          if (isset($_POST["Medicine_$i"]) && !empty($_POST["Medicine_$i"])) {
              $medicine = sanitize($_POST["Medicine_$i"]);
              $quantity = isset($_POST["Quantity_$i"]) ? sanitize($_POST["Quantity_$i"]) : 0;
              $medicines[] = $medicine;
              $quantities[] = $quantity;
          }
      }
  
      $lastIdResult = $conn->query("SELECT MAX(id) AS max_id FROM prescription");
      $lastIdRow = $lastIdResult->fetch_assoc();
      $lastId = $lastIdRow['max_id'] ? $lastIdRow['max_id'] : 0;
      $newId = $lastId + 1;
  
      // Insert each medicine as a separate row with the new prescription ID
      foreach ($medicines as $index => $medicine) {
          $quantity = $quantities[$index];
  
          $sql = "INSERT INTO prescription (id, pname, page, pgender, medicine, quantity, doctor) 
                  VALUES ('$newId', '$patient_name', '$age', '$gender', '$medicine', '$quantity', '$doctorName')";
  
          if ($conn->query($sql) !== TRUE) {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
  
      echo "<script>window.location.href = 'addprescreption.php';</script>";
  
      // Close the database connection
      $conn->close();
  }
  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="fav1.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>addprescreption</title>
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
    <style>
      .formcontac {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; /* Add transition property */
}

.formcontac:focus {
  border-color: #11c393;
  outline: 0; /* Remove default outline */
  box-shadow: 0 0 0 0.2rem #b8f0e1; /* Add box shadow when focused */
}
      </style>
    
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
          <h2>Prescription</h2>
          
        </div>
        <form  method="post" id="addMedicineForm">
        <div class="square">
    <div class="row3">
        <div class="form-wrapper">
            <label class="formlab" for="Patient_name">Patient-name</label>
            <input type="text" name="Patient_name" id="Patient_name" placeholder="Patient_name" class="formcontac">
        </div>
        <div class="form-wrapper">
            <label class="formlab" for="Age">Age</label>
            <input type="text" name="Age" id="Age" placeholder="Age" class="formcontac">
        </div>
        <div class="form-wrapper">
    <label class="formlab" for="Gender">Gender</label>
    <select name="Gender" id="Gender" class="formcontact">
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>
</div>

    </div>
    <div class="row3">
        <!-- First Row -->
        <div class="form-wrapper">
            <label class="formlab" for="Medicine_1">Medicine 1</label>
            <input type="text" name="Medicine_1" id="Medicine_1" placeholder="Medicine 1" class="formcontact">
            <input type="number" name="Quantity_1" id="Quantity_1" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
        </div>

        <div class="form-wrapper">
            <label class="formlab" for="Medicine_2">Medicine 2</label>
            <input type="text" name="Medicine_2" id="Medicine_2" placeholder="Medicine 2" class="formcontact">
            <input type="number" name="Quantity_2" id="Quantity_2" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
        </div>

        <div class="form-wrapper">
            <label class="formlab" for="Medicine_3">Medicine 3</label>
            <input type="text" name="Medicine_3" id="Medicine_3" placeholder="Medicine 3" class="formcontact">
            <input type="number" name="Quantity_3" id="Quantity_3" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
        </div>
    </div>

    <div class="row3">
        <div class="form-wrapper">
            <label class="formlab" for="Medicine_4">Medicine 4</label>
            <input type="text" name="Medicine_4" id="Medicine_4" placeholder="Medicine 4" class="formcontact">
            <input type="number" name="Quantity_4" id="Quantity_4" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
        </div>
        <div class="form-wrapper">
            <label class="formlab" for="Medicine_5">Medicine 5</label>
            <input type="text" name="Medicine_5" id="Medicine_5" placeholder="Medicine 5" class="formcontact">
            <input type="number" name="Quantity_5" id="Quantity_5" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
        </div>
        <div class="form-wrapper">
            <label class="formlab" for="Medicine_6">Medicine 6</label>
            <input type="text" name="Medicine_6" id="Medicine_6" placeholder="Medicine 6" class="formcontact">
            <input type="number" name="Quantity_6" id="Quantity_6" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
        </div>
    </div>

<div class="additional-inputs">
</div>
<div>
  
</div>

<div>
    <button type="submit" class="btn ">   Submit   </button>
    <button type="button" id="addMedicineButton" class="btn add-medicine-btn cssbuttons-io-button">Add Medicine <span class="icon">+</span></button>

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
document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.querySelector('.add-medicine-btn'); // Updated selector
    const additionalInputs = document.querySelector('.additional-inputs');
    let medicineCount = 6;
    let count;
    let count1;

    if (addButton) {
        addButton.addEventListener('click', addMedicine);
    }
    function addMedicine() {
      
       
       
    
        if (medicineCount === 6) {
            medicineCount++;
        } else {
            medicineCount = count1 + 1;
        }

        count = medicineCount + 1;
        count1 = count + 1;

        const inputField = `
            <div class="row3">
                <div class="form-wrapper">
                    <label class="formlab" for="Medicine_${medicineCount}">Medicine ${medicineCount}</label>
                    <input type="text" name="Medicine_${medicineCount}" id="Medicine_${medicineCount}" placeholder="Medicine ${medicineCount}" class="formcontact">
                    <input type="number" name="Quantity_${medicineCount}" id="Quantity_${medicineCount}" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
                </div>
                <div class="form-wrapper">
                    <label class="formlab" for="Medicine_${count}">Medicine ${count}</label>
                    <input type="text" name="Medicine_${count}" id="Medicine_${count}" placeholder="Medicine ${count}" class="formcontact">
                    <input type="number" name="Quantity_${count}" id="Quantity_${count}" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
                </div>
                <div class="form-wrapper">
                    <label class="formlab" for="Medicine_${count1}">Medicine ${count1}</label>
                    <input type="text" name="Medicine_${count1}" id="Medicine_${count1}" placeholder="Medicine ${count1}" class="formcontact">
                    <input type="number" name="Quantity_${count1}" id="Quantity_${count1}" class="formquantity" placeholder="Qty" min="0" style="width: 50px; margin-left: 10px;">
                </div>
            </div>
        `;

        additionalInputs.insertAdjacentHTML('beforeend', inputField);
        $('.formcontact').autocomplete({
                source: response,
                minLength: 1 // Minimum characters before triggering autocomplete
            });
    }
});
$(document).ready(function() {
    // Make AJAX request to fetch medicine names
    $.ajax({
        url: 'fetmed.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Add autocomplete functionality to existing and future input fields
            $('body').on('focus', '.formcontact', function() {
                $(this).autocomplete({
                    source: response,
                    minLength: 1 // Minimum characters before triggering autocomplete
                });
            });
        }
    });

    // Add event listener to detect the addition of new input fields
    $('body').on('DOMNodeInserted', '.row3', function() {
        // Apply autocomplete to the newly added input field
        $(this).find('.formcontact').autocomplete({
            source: response,
            minLength: 1 // Minimum characters before triggering autocomplete
        });
    });
});


$(document).ready(function(){
    $('#comment_form').on('submit', function(event){
        event.preventDefault();

        var patient_name = $('#patient_name').val();
        var age = $('#age').val();
        var gender = $('#gender').val();
        var medicines = [];
        for (var i = 1; i <= 12; i++) {
            var medicine = $('#Medicine_' + i).val();
            if (medicine !== '') {
                medicines.push(medicine);
            }
        }

        if (patient_name !== '' && age !== '' && gender !== '') {

            var form_data = $(this).serializeArray();
            form_data.push({name: "Patient_name", value: patient_name});
            form_data.push({name: "Age", value: age});
            form_data.push({name: "Gender", value: gender});
            for (var j = 0; j < medicines.length; j++) {
                form_data.push({name: "Medicine_" + (j+1), value: medicines[j]});
            }

            $.ajax({

                url: "addprescreption.php",
                method: "POST",
                data: form_data,
                success: function(data) {

                    $('#comment_form')[0].reset();
                    load_unseen_notification();

                }

            });

        } else {
            alert("All Fields are Required");
        }

    });

    // load new notifications

});

// load new notifications



</script>
<script>
        const medicines = [1, 2, 3, 4, 5, 6];

        medicines.forEach(num => {
            document.getElementById(`Quantity_${num}`).addEventListener('input', function () {
                const medicineName = document.getElementById(`Medicine_${num}`).value;
                const quantity = document.getElementById(`Quantity_${num}`).value;

                if (medicineName && quantity) {
                    // Create an AJAX request to check the available quantity in the database
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'chek.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            const availableQuantity = parseInt(xhr.responseText);
                            const quantityInput = document.getElementById(`Quantity_${num}`);

                            if (quantity > availableQuantity) {
                                quantityInput.classList.add('red');
                            } else {
                                quantityInput.classList.remove('red');
                            }
                        }
                    };
                    xhr.send(`medicine=${medicineName}`);
                }
            });
        });
    </script>


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
  <style>
    .cssbuttons-io-button {
  display: flex;
  align-items: center;
  justify-content: center;
 
  font-family: inherit;
  font-weight: 600;
  font-size: 16px;
  padding: .5em 1.5em;
  color: white;
  background: linear-gradient(0deg, rgb(0, 150, 60), rgb(100, 250, 150));
  border: none;
  outline: none;
  border-bottom: 3px solid rgb(0, 130, 40);
  box-shadow: 0 .5em .5em -.4em rgb(0, 0, 0, .5);
  letter-spacing: 0.08em;
  border-radius: 20em;
  cursor: pointer;
  transition: .5s;
  margin-left:760px; margin-top: -40px;
  
}
.formquantity.red {
            border-color: red;
}
.cssbuttons-io-button:hover {
  filter: brightness(1.2);
  color: rgb(0, 0, 0, .5);
}

.cssbuttons-io-button:active {
  transition: 0s;
  transform: rotate(-10deg);
}
</style>


</body>
</html>