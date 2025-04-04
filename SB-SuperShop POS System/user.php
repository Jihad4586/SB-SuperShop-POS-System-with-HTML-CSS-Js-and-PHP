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

// Fetch users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="sidebar">
        <h2>SB-SuperShop</h2>
        <ul>
          <li><a href="homepage.html">Dashboard</a></li>
          <li><a href="Inventory.html">Inventory</a></li>
          <li><a href="cashier.html">Cashier</a></li>
          <li><a href="user.php">Users</a></li>
          <li><a href="LogPage.php">Logout</a></li>
        </ul>
      </div>

  <div class="container">
  <main>
      <header>
        <h2>Users (<?php echo $result->num_rows; ?>)</h2>
        <a href="newuser.html" id="new-user-btn">New User</a>
      </header>
      <div class="search-bar">
        <form method="GET" action="">
          <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
          <button type="submit">Search</button>
        </form>
      </div>
      <table>
        <thead>
          <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>Image</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Permission</th>
            <th>Username</th>
            <th>Password</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Handle search
          if (isset($_GET['search']) && !empty($_GET['search'])) {
              $search = $conn->real_escape_string($_GET['search']);
              $sql = "SELECT * FROM users WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR username LIKE '%$search%'";
              $result = $conn->query($sql);
          }

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "
                  <tr>
                    <td><input type='checkbox'></td>
                    <td><img src='uploads/{$row['profile_picture']}' alt='Profile' width='50' height='50'></td>
                    <td>{$row['first_name']} {$row['last_name']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['age']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['username']}</td>
                    <td>********</td>
                    <td>
                      <form method='POST' action='userdelete.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit'>Delete</button>
                      </form>
                      <form method='GET' action='userupdate.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit'>Update</button>
                      </form>
                    </td>
                  </tr>
                  ";
              }
          } else {
              echo "<tr><td colspan='9'>No users found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
<?php
$conn->close();
?>
