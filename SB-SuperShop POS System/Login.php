<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sb_supershop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to verify username and password
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful, redirect to the dashboard
        header("Location: Homepage.html");
        exit();
    } else {
        // Invalid username or password
        $error_message = "Invalid username or password!";
    }
}

// Close the database connection
$conn->close();
?>
