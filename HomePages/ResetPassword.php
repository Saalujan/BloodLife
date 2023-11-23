<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forgot.css">
    <title>Forgot Password - Reset Password</title>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="HomePages/Resetpasswordprocess.php" method="post">
            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new-password" required>
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
