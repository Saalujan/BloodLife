<?php
require_once '../classes/Validation.php';
require_once '../classes/User.php';

use classes\Validation;
use classes\User;


$status;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    if (isset($_POST["VerificationCode"], $_SESSION["VerificationCode"],  $_SESSION["email"], $_SESSION['timestamp'])) {
        $verifyOtp = (int) $_POST["VerificationCode"] === (int) $_SESSION["VerificationCode"];
        $time = time() - $_SESSION['timestamp'] > 60000000;

        if ($verifyOtp) {
header("location : HomePages/ResetPassword.php");
            
        } else {
            unset($_SESSION["VerificationCode"]);
            unset($_SESSION['timestamp']);
            $status = !$verifyOtp ? 3 : (!$time ? 4 : 5);
        }
    } else if (isset($_POST['email'])) {





        if (!empty($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $validateEmail = Validation::validateGmail($email);
            $emailExist = Validation::validateAlreadyExist("email", $email, "user");
            $user = new User(null, null, null, null, null, null, null, null, null);
            if ($validateEmail) {

                // Use the emailExistsInDatabase function from DatabaseFunctions.php
                if ($emailExist) {
                    // Email exists in the database


                    $_SESSION["VerificationCode"] = Validation::generateOTP();
                    $_SESSION["email"] = $email;
                    $_SESSION['timestamp'] = time();

                    $status = User::SendVerificationCode($_SESSION["VerificationCode"], $email) ? header("Location: OTP.php") : 2;
                } else {
                    // Email does not exist in the database
                    $status = '3';
                }
            } else {
                // Invalid email format
                $status = '4';
            }
        } else {
            // Email not provided
            $status = '45';
        }
    } else {
        echo "aasadh";
        echo $_SESSION["VerificationCode"];
    }
} else {
    // Email not provided
    $status = '6';
}
echo $status;
