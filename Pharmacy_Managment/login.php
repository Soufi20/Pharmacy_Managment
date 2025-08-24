<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$database = "eph_dr_saadane";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['ID'];
    $password = $_POST['password'];
    $role = $_POST['selectedOption'];

    $sql = "SELECT * FROM $role WHERE id = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User authenticated, set session variables and cookies
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        
        $cookie_name = "user";
        $cookie_value = $username; // You can set the cookie value to any user identifier you want

        // Set cookie to expire in 30 days (you can adjust the expiration time as needed)
        $cookie_expire = time() + (30 * 24 * 60 * 60); // 30 days
        setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
        if ($role=="doctor") {
            header("Location: index2.php");
        exit(); 
        }else{
            header("Location: index.php");
            exit(); 
        }

       
    } else {
        echo "Invalid username or password!";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/png" href="fav1.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
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
    width: 700px;
    height: 450px;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
    align-items: center;
    margin: auto;
    border: 2px solid rgb(238, 241, 241);
    border-radius: 40px;
    background: #7adac5;
    box-shadow: 0 0 25px #575555  ;
}

.login-form {
    margin-left: 45%; 
    margin-top: -180px; 
}
  
h2 {
    position: relative; 
    top: -10px; 
    right: -140px; 
    top: 50px; 
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
.active {
background: #23242a;
}
.select {
background: #2a2f3b;
color: #fff;
display: flex;
justify-content: space-between;
align-items: center;
border: 2px #2a2f3b solid;
border-radius: 0.5em;
padding: 1em;
cursor: pointer;
transition: background 0.3s;
}
.select:hover {
background: #323741;
}
.select-clicked {
border: 2px #26489a solid;
box-shadow: 0 0 0.8em #26489a;
}
.caret {
width: 0;
height: 0;
border-left: 5px solid transparent;
border-right: 5px solid transparent;
border-top: 6px solid #fff;
transition: 0.3s;
}
.caret-rotate {
transform: rotate(180deg);
}
.dropdown {
min-width: 15em;
position: relative;
margin: 2em;
}
.dropdown * {
box-sizing: border-box;
}
.menu {
list-style: none;
padding: 0.2em 0.5em;
background: #323741;
border: 1px #363a43 solid;
box-shadow: 0 0.5em 1em rgba(0, 0, 0, 0.2);
border-radius: 0.5em;
color: #9fa5b5;
position: absolute;
top: 3em;
left: 50%;
width: 100%;
transform: translateX(-50%);
opacity: 0;
display: none;
transition: 0.2s;
z-index: 1;
}
.menu li {
padding: 0.7em 0.5em;
margin: 0.3em 0;
border-radius: 0.5em;
cursor: pointer;
}
.menu li:hover {
background: #2a2d35;
}
.menu-open {
display: block;
opacity: 1;
}
.log{
    
}
</style>
</head>
<body>
    <div class="body-content">
        <div class="container">
            <h2  class="log">LOG IN</h2>
            <img src="image1.png"  class="image" >
            <div class="login-form">
                <form id="loginForm" action="login.php" method="POST">
                    <div class="form-item-ID">
                        <input type="text" name="ID" id="ID" placeholder="Drop your ID here" pattern="\d+" title="Please enter only digits">
                    </div>
                    <div class="form-item-password">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    
                    <div class="dropdown">
                        <div class="select">
                            <span class="selected">LOGIN AS</span>
                            <div class="caret"></div>
                        </div>
                        <ul class="menu">
                            <li value="Doctor" name="remembe[]" id="doctor">doctor</li>
                            <li value="Pharma" name="remembe[]" id="pharmacist">pharmacist</li>
                           
                        </ul>
                        <input type="hidden" name="selectedOption" value="">

                    </div>
                    <div class="options">
                    don't have an account?<a href="signup.php">signup</a>
                    </div>
                    
                </form>
                <p>Copyright © YourCompany.com</p>
            </div>
        </div>
    </div>

    <script>
      
      document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const select = dropdown.querySelector('.select');
        const caret = dropdown.querySelector('.caret');
        const menu = dropdown.querySelector('.menu');
        const options = dropdown.querySelectorAll('.menu li');
        const selected = dropdown.querySelector('.selected');
        const hiddenInput = dropdown.querySelector('input[name="selectedOption"]'); // Add this line

        select.addEventListener('click', () => {
            select.classList.toggle('select-clicked');
            caret.classList.toggle('caret-rotate');
            menu.classList.toggle('menu-open');
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                selected.innerText = "LOGIN AS " + option.innerText;
                select.classList.remove('select-clicked');
                caret.classList.remove('caret-rotate');
                menu.classList.remove('menu-open');
                options.forEach(option => {
                    option.classList.remove('active');
                });
                option.classList.add('active');
                
                
                hiddenInput.value = option.innerText;
                form.submit();
            });
        });
    });



    const form = document.getElementById('loginForm');
    const usernameInput = document.getElementById('ID');
    const passwordInput = document.getElementById('password');
    const termsCheckbox = document.getElementById('remember');
    const loginButton = document.querySelector('.Login'); // Changed class name

    function checkConditions() {
        if (usernameInput.validity.valid &&
            passwordInput.validity.valid &&
            termsCheckbox.checked) {
            loginButton.disabled = false;
        } else {
            loginButton.disabled = true;
        }
    }

    usernameInput.addEventListener('input', checkConditions);
    passwordInput.addEventListener('input', checkConditions);
    termsCheckbox.addEventListener('change', checkConditions);
});

        
    </script>
</body>
</html>
