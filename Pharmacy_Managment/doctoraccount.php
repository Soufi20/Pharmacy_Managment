<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eph_dr_saadane";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the pharmacist array
$pharmacist = [];

// Check if the ID is provided
if (isset($_GET['usernam'])) {
    $id = $_GET['usernam'];

    // Prepare SQL statement to select pharmacist by ID
    $stmt = $conn->prepare("SELECT * FROM doctor WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if pharmacist is found
    if ($result->num_rows > 0) {
        $pharmacist = $result->fetch_assoc();
    } else {
        echo "Pharmacist not found!";
    }
}

// Check if form is submitted to update pharmacist details
if (isset($_POST['id']) && isset($_POST['contact']) && isset($_POST['password']) && isset($_POST['name'])) {
    $id = $_POST['id'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    // Prepare SQL statement to update pharmacist details
    $stmt = $conn->prepare("UPDATE doctor SET name = ?, contact = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $contact, $password, $id);

    // Execute the update statement
    if ($stmt->execute()) {
        echo "Pharmacist details updated successfully!";
    } else {
        echo "Error updating pharmacist details: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="fav1.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Edit Doctor</title>
    <!-- Montserrat Font -->
    <link href="css/css2.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="css/icon.css" rel="stylesheet">
    <script src="js/644d5fa036.js" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .grid-container1 {
            display: grid;
            grid-template-columns: auto; 
        }

        .header1 {
            grid-column: 1;
        }

        .main-container1 {
            grid-column: 1;
            padding: 20px; 
        }

        .square1 {
            width: calc(100% - 40px); 
            height: calc(100vh - 60px); 
            border: 0.1px solid #c5e0f8;
            border-radius: 10px;
            padding: 20px; 
            margin: 20px; 
        }
    </style>
</head>
<body>
    <div class="grid-container1">
        <main class="main-container1">
            <div class="main-title">
                <h2>Edit Doctor</h2>
            </div>
            <form action="pharmaacount.php" method="post">
                <div class="square1">
                    <div class="row3">
                        <div class="form-wrapper">
                            <label class="formlab" for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Pharmacist Name" class="formcontact" value="<?php echo isset($pharmacist['name']) ? $pharmacist['name'] : ''; ?>" >
                        </div>
                        <div class="form-wrapper">
                            <label class="formlab" for="contact">Contact</label>
                            <input type="text" name="contact" id="contact" placeholder="Contact" class="formcontact" value="<?php echo isset($pharmacist['contact']) ? $pharmacist['contact'] : ''; ?>">
                        </div>
                        <div class="form-wrapper">
                            <label class="formlab" for="password">Password</label>
                            <input type="text" name="password" id="password" placeholder="Password" class="formcontact" value="<?php echo isset($pharmacist['password']) ? $pharmacist['password'] : ''; ?>">
                        </div>
                        <input type="hidden" name="id" value="<?php echo isset($pharmacist['id']) ? $pharmacist['id'] : ''; ?>">
                    </div>
                    
                    <div>
                        <button type="submit" class="btn">Update Pharmacist</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
