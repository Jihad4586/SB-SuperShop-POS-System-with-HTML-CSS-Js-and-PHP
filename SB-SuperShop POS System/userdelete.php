<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sb_supershop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Delete user query
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: user.php");
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

$conn->close();
?>
