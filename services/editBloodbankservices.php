<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace classes;

require '../classes/district.php';
require '../classes/bloodBank.php';
require '../classes/Validation.php';
require_once '../classes/User.php';

use classes\district;
use classes\bloodBank;
use classes\Validation;
use classes\User;

$status = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["OldPassword"], $_POST["newpassword"], $_POST["confirmPassword"], $_POST["token"])) {
        $userChangePassword = new User(null, null, null, null, $_POST["token"], null, null, null, null);
        $validateToken = $userChangePassword->validateToken();
        $userrole = $userChangePassword->getUserRole();
        
        if (($validateToken && $userrole == 2)) {
            if ($_POST["newpassword"] === $_POST["confirmPassword"]) {
            if ($userChangePassword->verifyPassword($userChangePassword->getEmail(), $_POST["OldPassword"])) {
               
                    if(Validation::validatePassword($_POST["newpassword"])){
                    if ($userChangePassword->changePassword($userChangePassword->getEmail(), $_POST["newpassword"])) {
                        $status = "Password change successfully"; 
                    }else{
                        $status = "Password didn't change";  
                    }
                }else{
                    $status = "Storng password must contain 8digits ,symbals, 1 capital letter";
                }
                }else{
                    $status = "Old Password In Not Correct"; 
                }
            }else{
                $status = "New Password and Confirm password is not match"; 
            }
        }else{
            $status = "UnAuthorized Token";
        }
    } else if (isset(
        $_POST["bloodBankName"],
        $_POST["Address"],
        $_POST["ContactNo"],
        $_POST["district"],
        $_POST["division"],
        $_POST["token"],
        $_POST["bloodBankId"]
    )) {

        //empty value check
        if (
            !empty($_POST["bloodBankName"]) && ($_POST["Address"]) && ($_POST["ContactNo"]) &&
            ($_POST["district"]) && ($_POST["division"]) && ($_POST["token"]) && $_POST["bloodBankId"]
        ) {


            // sanitizing the inputs
            $bloodBankName = filter_var($_POST['bloodBankName'], FILTER_SANITIZE_STRING);
            $Address = filter_var($_POST['Address'], FILTER_SANITIZE_STRING);
            $ContactNo = filter_var($_POST['ContactNo'], FILTER_SANITIZE_STRING);
            $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
            $district = filter_var($_POST['district'], FILTER_SANITIZE_STRING);
            $division = filter_var($_POST['division'], FILTER_SANITIZE_STRING);
            $bloodBankId = filter_var($_POST['bloodBankId'], FILTER_VALIDATE_INT);


            $districtId = district::getDistrictIDDD($district, $division);
            // echo $districtId;

            //create user object with token
            $user = new User(null, null, null, null, $token, null, null, null, null);
            //validations


            $validatePhoneNumber = Validation::validateContactNumber($ContactNo);
            $validateToken = $user->validateToken();
            $userrole = $user->getUserRole();
         


            // echo $token;
            // echo $userrole;
            //token  checking
            if (($validateToken && $userrole == 1) || ($validateToken && $userrole == 2)) {
             

                //email,phonenumber validation check
                if ($validatePhoneNumber) {

                   
                    //create bloodbank object
                    $bloodbank = new bloodbank($bloodBankId, $bloodBankName, $Address, $ContactNo, $districtId);

                    

                    if ($bloodbank->editBloodbank()) {
                        $status = 1;
                    } else {
                        $status = 2;
                    }
                } else {
                    //check status for valitations
                    $status = !$validatePhoneNumber ? 12 : 13;
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
        $status = 17;
    }
} else {

    echo "Invalid request method";
}

echo $status;
