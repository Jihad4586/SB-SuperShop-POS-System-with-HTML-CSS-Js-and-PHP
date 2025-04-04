<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sb_supershop"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hash the password
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $type = $_POST['type'];

    // File upload handling
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
    }

    $file_name = basename($_FILES["profile_picture"]["name"]);
    $target_file = $target_dir . $file_name;
    $upload_success = false;

    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        $upload_success = true;
    } else {
        echo "Error: Unable to upload the file. Please check directory permissions.<br>";
        echo "Temp file: " . $_FILES["profile_picture"]["tmp_name"] . "<br>";
        echo "Target file: " . $target_file . "<br>";
    }

    // Check if the username already exists
    $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($check_username_sql);

    if ($result->num_rows > 0) {
        echo "Error: Username already exists. Please choose a different username.";
    } else {
        // Insert data into the database if upload was successful
        if ($upload_success) {
            $sql = "INSERT INTO users (first_name, last_name, username, password, gender, age, type, profile_picture) 
                    VALUES ('$first_name', '$last_name', '$username', '$password', '$gender', '$age', '$type', '$file_name')";

            if ($conn->query($sql) === TRUE) {
                header("Location: user.php");

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "User registration failed due to file upload issues.";
        }
    }
}

$conn->close();
?>
