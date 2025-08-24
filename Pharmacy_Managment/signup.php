<?php
session_start(); // Start or resume the session

$servername = "localhost";
$username = "root";
$password = "";
$database = "eph_dr_saadane";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $id = $_POST['ID'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];
    $department = $_POST['doctorField']; 
    
    $roles = [];
    
    if(isset($_POST['remember'])){
        foreach($_POST['remember'] as $selected){
            if($selected == 'DOCTOR'){
                $roles[] = "Doctor";
            }
            elseif($selected == 'pharmacist'){
                $roles[] = "pharmacist";
            }
           
        }
    }
    
    $name = $firstName . " " . $lastName;

    try {
        foreach ($roles as $role) {
            if ($role == "Doctor") {
                $sql = "INSERT INTO $role (name, id, password, contact, department) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $name, $id, $password, $contact, $department);
            } else {
                $sql = "INSERT INTO $role (name, id, password, contact) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $name, $id, $password, $contact);
            }
            
            if ($stmt->execute() === TRUE) {
                // Fetch the name based on the inserted ID
                $sql = "SELECT name FROM $role WHERE id = '$id'";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // Fetch the row from the result set
                    $row = $result->fetch_assoc();
                    
                    // Store the username in the session variable
                    $_SESSION['username'] = $row['name'];
                    
                    // Set cookie to remember user login status
                    $cookie_name = "user";
                    $cookie_value = $id; // You can set the cookie value to any user identifier you want

                    // Set cookie to expire in 30 days (you can adjust the expiration time as needed)
                    $cookie_expire = time() + (30 * 24 * 60 * 60); // 30 days
                    setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
                    
                    if ($role=="Doctor") {
                        header("Location: index2.php");
                    exit(); 
                    }else{
                        header("Location: index.php");
                        exit(); 
                    }
                } 
            } 
        }   
    } catch (Exception $e) {
        // Handle exceptions
        header("Location: login.php");
        exit();
    }
    
    $stmt->close();
    $conn->close();
}
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/png" href="fav1.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up</title>
<style>
  html {
    background-image: url('bacgrawnd.JPG');
    background-size: cover; 
    background-position: center; 
}

  
  .body-content {
      padding-top: 10vh;
  }
  
  .container {
    max-width: 700px; /* Limit maximum width */
    width: 100%; /* Take full width available */
    min-height: 450px; /* Minimum height */
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    margin: auto;
    border: 2px solid rgb(238, 241, 241);
    border-radius: 15px;
    background: #7adac5;
    box-shadow: 0 0 25px #575555;
    padding: 20px; /* Added padding for spacing */
}


.login-form {
    margin-left: 45%; 
    margin-top: -250px; 
}
  
h2 {
    position: relative; 
    top: -10px; 
    right: -150px; 
    top: 10px; 
}
  
  form {
      display: flex;
      flex-direction: column;
  }
  
  .form-item {
      margin: 5px;
      padding-bottom: 10px;
      display: flex;
  }
  
  .form-item input {
      width: 150px;
      height: 30px;
      border: 2px solid #e1dede69;
      border-radius: 5px;
      background: white;
      color: black;
      text-align: left;
      margin: 0 5px;
  }
  
  .form-item-ID {
      margin: 0 5px;
      padding-bottom: 10px;
      display: flex;
      flex-direction: column;
  }
  
  .form-item-ID input {
      height: 30px;
      border: 2px solid #e1dede69;
      border-radius: 5px;
      background: white;
      color: black;
      text-align: left;
      margin: 0 5px;
  }
  
  .form-item-password {
      margin: 5px;
      padding-bottom: 10px;
      display: flex;
      flex-direction: column;
  }
  
  .form-item-password input {
      height: 30px;
      border: 2px solid #e1dede69;
      border-radius: 5px;
      background: white;
      color: black;
      text-align: left;
      margin: 5px 5px;
  }
  
  .remember-box {
      margin: auto;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 15px;
      color: white;
      display: flex;
  }
  
  .remember-box a {
      text-decoration: none;
      color: white;
      margin-left: 30px;
  }
  
  .remember-box a:hover {
      color: grey;
  }
  
  .form-btns {
      display: flex;
      flex-direction: column;
      margin: auto;
      padding: 10px 0;
  }
  
  .form-btns button {
      margin: auto;
      font-size: 20px;
      padding: 5px 15px;
      border: 0;
      border-radius: 15px;
      color: rgb(75, 61, 61);
      background: #fbba50;
      width: 280px;
      cursor: pointer;
  }
  
  .form-btns button:disabled {
      background: #8f8b85 !important;
      color: rgb(131, 120, 120) !important;
      cursor: not-allowed;
  }
  
  .form-btns button:hover {
      background: #d88a0c;
      color: antiquewhite;
  }
  
  .options {
      padding-top: 15px;
      margin: auto;
      color: white;
      font-size: 13px;
      font-family: Arial, Helvetica, sans-serif;
  }
  
  .options a {
      font-size: 13px;
      color: white;
  }
  
  .options a:hover {
      color: rgb(167, 165, 165);
  }
  
  p {
      text-align: center;
      font-size: 12px;
      font-family: Arial, Helvetica, sans-serif;
      color: white;
  }

  .image {
    float: left; 
    margin-left: -400px; 
    width: 300px;
    margin-right: 500px; 
    margin-left: 60px; 
    height: auto;
    border-radius: 10px;
    
    
} 

input:invalid {
    border-color: red;
}
#ID:invalid {
    border-color: red;
}

.form-item-contact {
    margin: 5px;
    padding-bottom: 10px;
    display: flex;
    flex-direction: column;
}

.form-item-contact input {
    height: 30px;
    border: 2px solid #e1dede69;
    border-radius: 5px;
    background: white;
    color: black;
    text-align: left;
    margin: 0 5px;
}



    


</style>
</head>
<body>
   

<div class="body-content">
    <div class="container">
        <h2>Sign Up</h2>
       <img src="image1.png"  class="image" >
        
        
        <div class="login-form">
            <form action="signup.php" method="post">
            
         
                <div class="form-item">
                    <input type="text" name="firstName" id="firstName" placeholder="First Name"/>
                    <input type="text" name="lastName" id="lastName" placeholder="Last Name"/>
                </div>
                <div class="form-item-ID">
                    <input type="text" name="ID" id="ID" placeholder="ID" pattern="\d+" title="Please enter only digits">

                </div>
                <div class="form-item-password">
                    <input type="password" name="password" id="password" placeholder="Password"  title="Password must be at least 8 characters long">
                    
                    
                </div>
                <div class="form-item-contact">
                    <input type="text" name="contact" id="contact" placeholder="Contact"/>
                </div>
                
                <div class="remember-box">
                    <input type="checkbox" name="remember[]" id="DOCTOR" value="DOCTOR"/>
                        <label for="DOCTOR">sign as doctor</label>
                            <input type="checkbox" name="remember[]" id="PHARMA" value="pharmacist"/>
                             <label for="PHARMA">sign as pharma</label>
                </div>

                <div class="form-item" id="doctorInput" style="display: none;">
                    <input type="text" name="doctorField" id="doctorField" placeholder="Departement"  list="departments" />
                    <datalist id="departments">
                        <option value="Accident and Emergency (A&E)">
                        <option value="Admissions">
                        <option value="Anesthetics">
                        <option value="Breast Screening">
                        <option value="Burn Center (Burn Unit or Burns Unit)">
                        <option value="Cardiology">
                        <option value="Central Sterile Services Department (CSSD)">
                        <option value="Chaplaincy">
                        <option value="Coronary Care Unit (CCU)">
                        <option value="Critical Care">
                        <option value="Diagnostic Imaging">
                        <option value="Discharge Lounge">
                        <option value="Elderly Services">
                        <option value="Finance Department">
                        <option value="Gastroenterology">
                        <option value="General Services">
                        <option value="General Surgery">
                        <option value="Gynecology">
                        <option value="Hematology">
                        <option value="Health & Safety">
                        <option value="Intensive Care Unit (ICU)">
                        <option value="Human Resources">
                        <option value="Infection Control">
                        <option value="Information Management">
                        <option value="Maternity">
                        <option value="Medical Records">
                        <option value="Microbiology">
                        <option value="Neonatal">
                        <option value="Nephrology">
                        <option value="Neurology">
                        <option value="Nutrition and Dietetics">
                        <option value="Obstetrics/Gynecology">
                        <option value="Occupational Therapy">
                        <option value="Oncology">
                        <option value="Ophthalmology">
                        <option value="Orthopedics">
                        <option value="Otolaryngology (Ear, Nose, and Throat)">
                        <option value="Pain Management">
                        <option value="Patient Accounts">
                        <option value="Patient Services">
                        <option value="Pharmacy">
                        <option value="Physiotherapy">
                        <option value="Purchasing & Supplies">
                        <option value="Radiology">
                        <option value="Radiotherapy">
                        <option value="Renal">
                        <option value="Rheumatology">
                        <option value="Sexual Health">
                        <option value="Social Work">
                        <option value="Urology">
                    </datalist>
                </div>
                
                <div class="form-btns">
                    <button class="signup" type="submit" >Sign Up</button>
                    <div class="options">
                        Already have an account? <a href="Login.php">Login here</a>
                    </div>
                </div>
            </form>
            <p>Copyright © YourCompany.com</p>
        </div>
    </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.remember-box input[type="checkbox"]');
    const doctorInput = document.getElementById('doctorInput');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                if (cb !== this) {
                    cb.checked = false;
                }
            });

            if (this.checked && this.value === 'DOCTOR') {
                doctorInput.style.display = 'block';
            } else {
                doctorInput.style.display = 'none';
            }
        });
    });



        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const signupButton = document.getElementById('signupButton');

        function validateData() {
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const id = document.getElementById('ID').value.trim();
            const passwordValue = password.value;
            const confirmPasswordValue = confirmPassword.value;

            
           
        }

        password.addEventListener('change', validateData);
        confirmPassword.addEventListener('keyup', validateData);
    });
</script>

</body>
</html>
  