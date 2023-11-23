<?php
require_once '../classes/User.php';
require_once '../classes/Validation.php';

use classes\User;
use classes\Validation;

header('Content-Type: application/json');
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data["new-password"]) && isset($data["confirm-password"])) {
        $newPassword = $data["new-password"];
        $confirmPassword = $data["confirm-password"];

        if ($newPassword === $confirmPassword) {
            // Assuming you have a function to update the user's password in your User class
            // Also, validate the password based on your requirements using your Validation class
            if (Validation::validatePassword($newPassword)) {
                // Assuming you have a function to update the user's password in your User class
                // Replace User::updatePassword with the appropriate function
                if (User::updatePassword($newPassword)) {
                    // Redirect to Resetsuccess.html
                    header("Location: Resetsuccess.html");
                    exit();
                } else {
                    echo json_encode(array("message" => "Failed to update password"));
                }
            } else {
                echo json_encode(array("message" => "Invalid password format"));
            }
        } else {
            echo json_encode(array("message" => "Passwords do not match"));
        }
    } else {
        echo json_encode(array("message" => "New password and confirm password not provided"));
    }
} else {
    echo json_encode(array("message" => "Invalid request method."));
}
?>
