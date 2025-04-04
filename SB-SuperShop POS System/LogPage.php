<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form login-form">
                <h2>Login</h2>
                <p>Please login to use the SB-SuperShop</p>
                <form method="POST" action="Login.php">
                    <div class="from-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="from-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                      <?php if (!empty($error_message)): ?>
                      <p class="error-message"><?php echo $error_message; ?></p>
                      <?php endif; ?>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
