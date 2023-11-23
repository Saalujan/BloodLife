<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace classes;

require '../classes/district.php';
require '../classes/hospital.php';
require '../classes/Validation.php';
require_once '../classes/User.php';

use classes\district;
use classes\hospital;
use classes\Validation;
use classes\User;

$status = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();

    if (isset($_POST["VerificationCode"], $_SESSION["VerificationCode"], $_SESSION["hospital"], $_SESSION["email"], $_SESSION['timestamp'])) {
        //check status for adding hospital

        $verifyOtp = (int) $_POST["VerificationCode"] === (int) $_SESSION["VerificationCode"];
        $time = time() - $_SESSION['timestamp'] > 60000000;

        if ($verifyOtp) {
            
            $status = $_SESSION["hospital"]->AddHospital($_SESSION["email"]) ? 1 : 2;
            session_destroy();
            
        } else {
            unset($_SESSION["VerificationCode"]);
            unset($_SESSION['timestamp']);
            $status = !$verifyOtp ? 3 : (!$time ? 4 : 5);

        }
    } else if(isset($_POST["name"], $_POST["address"], $_POST["contactNumber"],
              $_POST["district"], $_POST["division"], $_POST["token"],
               $_POST["email"])) {

    //empty value check
    if (!empty($_POST["name"]) && ( $_POST["address"]) && ($_POST["contactNumber"]) &&
              ($_POST["district"]) && ($_POST["division"]) && ($_POST["token"]) &&
              ($_POST["email"])) {

   
    // sanitizing the inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $contactNumber = filter_var($_POST['contactNumber'], FILTER_SANITIZE_STRING);
    $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
    $district = filter_var($_POST['district'], FILTER_SANITIZE_STRING);
    $division = filter_var($_POST['division'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   
    
    $districtId = district::getDistrictIDDD($district, $division);
    // echo $districtId;
    
   
    //create user object with token
   $user = new User(null, null, null, null, $token, null, null, null, null);
    
    //validations
    $emailExist = Validation::validateAlreadyExist("email", $email, "user");
    $validateEmail = Validation::validateGmail($email);
    $validatePhoneNumber = Validation::validateContactNumber($contactNumber);
    $validateToken = $user->validateToken();
    $userrole= $user->getUserRole();
    
     //token  checking
     if ($validateToken && $userrole == 1) {

         //email,phonenumber validation check
         if ($validateEmail && $validatePhoneNumber ) {

            //email,username exist check in db
            if ( !$emailExist) {

                //create hospital object
                $hospital = new hospital(null, $name, $address, $contactNumber, $districtId);

                $_SESSION["VerificationCode"] = Validation::generateOTP();
                $_SESSION["hospital"] = $hospital;
                $_SESSION["email"] = $email;
                $_SESSION['timestamp'] = time();
                $status = User::SendVerificationCode($_SESSION["VerificationCode"],$email) ? header("Location: newEmptyPHPWebPage.php?type=hospital") : 7;

            } else {
                //check status for exist values
                $status = $emailExist ? 9 :  10;
            }
        } else {
            //check status for valitations
            $status = !$validateEmail ? 11 : (!$validatePhoneNumber ? 12 :13);
        }
    } else {
        //status for not valid token
        $status = 14;
    }
} else {
    //status for empty value
    $status = 15;
}
} else {
//status for isset value
$status = 16;
}
} else {

echo"Invalid request method";
}

    
echo $status;




?>






