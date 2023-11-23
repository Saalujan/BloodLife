<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forgot.css">
    <title>Forgot Password - Enter OTP</title>
</head>
<body>
    <div class="container">
        <h2>Enter OTP</h2>
        <?php
        session_start();
        echo $_POST["Verificationcode"];
        ?>
        <form action="OTPprocess.php" method="POST">
            <p>An OTP has been sent to your email. Please enter it below:</p>
            <label for="otp">OTP:</label>
            <input type="number"  name="VerificationCode" required>
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
