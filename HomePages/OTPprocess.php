<?php
require_once '../classes/User.php';
require_once '../classes/Validation.php';

use classes\User;
use classes\Validation;

header('Content-Type: application/json');
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data["otp"])) {
        $otp = $data["otp"];
        // Assuming you have a function to verify OTP in your Validation class
        if (Validation::verifyOTP($otp)) {
            // If OTP is valid, redirect to the Reset Password page
            header("Location: Resetsuccess.html");
            exit();
        } else {
            echo json_encode(array("message" => "Invalid OTP"));
        }
    } else {
        echo json_encode(array("message" => "OTP not provided"));
    }
} else {
    echo json_encode(array("message" => "Invalid request method."));
}
?>
