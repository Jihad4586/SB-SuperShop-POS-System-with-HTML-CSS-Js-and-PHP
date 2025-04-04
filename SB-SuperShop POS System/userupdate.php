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

// Retrieve user details for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $type = $_POST['type'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update query
    if (!empty($password)) {
        // Update with password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $sql = "UPDATE users SET first_name = ?, last_name = ?, gender = ?, age = ?, type = ?, username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssi", $first_name, $last_name, $gender, $age, $type, $username, $hashed_password, $id);
    } else {
        // Update without changing the password
        $sql = "UPDATE users SET first_name = ?, last_name = ?, gender = ?, age = ?, type = ?, username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissi", $first_name, $last_name, $gender, $age, $type, $username, $id);
    }

    if ($stmt->execute()) {
        header("Location: users.php");
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update User</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="form-container">
    <h2>Update User</h2>
    <form method="POST" action="">
      <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
      
      <label for="first_name">First Name</label>
      <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required>

      <label for="last_name">Last Name</label>
      <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required>

      <label for="gender">Gender</label>
      <select name="gender" required>
        <option value="Male" <?php echo $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
      </select>

      <label for="age">Age</label>
      <input type="number" name="age" value="<?php echo $user['age']; ?>" required>

      <label for="type">Permission</label>
      <select name="type" required>
        <option value="Admin" <?php echo $user['type'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
        <option value="Manager" <?php echo $user['type'] == 'Manager' ? 'selected' : ''; ?>>Manager</option>
        <option value="Cashier" <?php echo $user['type'] == 'Cashier' ? 'selected' : ''; ?>>Cashier</option>
      </select>

      <label for="username">Username</label>
      <input type="text" name="username" value="<?php echo $user['username']; ?>" required>

      <label for="password">New Password (leave blank to keep current password)</label>
      <input type="password" name="password" placeholder="Enter new password">

      <button type="submit">Update</button>
    </form>
  </div>
</body>
</html>
