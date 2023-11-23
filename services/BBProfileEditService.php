<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace classes;

require_once '../classes/bloodBank.php';
require_once  '../classes/district.php';
require_once  '../classes/User.php';
require_once  '../classes/Validation.php';

use classes\district;
use classes\bloodBank;
use classes\User;
use classes\Validation;


$status;
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset(
        $_POST["bloodBankId "],
        $_POST["bloodBankName"],
        $_POST["Address"],
        $_POST["ContactNo"],
        $_POST["districtId"],
       
       
    )) {

        //empty value check
        if (
            !empty($_POST["bloodBankId"]) && ($_POST["bloodBankName"]) && ($_POST["Address"]) &&
            ($_POST["ContactNo"])  &&
            ($_POST["districtId"])  )
        {

            // sanitizing the inputs

            $bloodBankId = filter_var($_POST['bloodBankId'], FILTER_SANITIZE_STRING);
            $bloodBankName = filter_var($_POST['bloodBankName'], FILTER_SANITIZE_STRING);
            $Address = filter_var($_POST['Address'], FILTER_SANITIZE_STRING);
            $ContactNo = filter_var($_POST['ContactNo'], FILTER_SANITIZE_STRING);
            $districtId = filter_var($_POST['districtId'], FILTER_SANITIZE_STRING);

           // $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
          



            //create user object with token
            $user = new User(null, null, null, null, $token, null, null, null, null);

            //validations
            $validateName = Validation::validateLettersLength($bloodBankName, 6);
            $validateAddress = Validation::validateLettersLength($Address, 6);
            //$validateDates = Validation::validateChamDate($startDate, $endDate);
            $districtId = district::getDistrictIDDD($district, $division);

            $validateToken = $user->validateToken();
            $bloodBankId = $user->getBloodBankId();
            //$campaignId = $campaign->getcampaignId();
            
            //token and bloodbank id checking
            if ($validateToken && $bloodBankId != null) {


                //email,phonenumber,nic,dob,bloodgroup valitaion check
                if ($validateName &&   $validateAddress) {


                    //create Campign object
                    $bloodBank  = new bloodBank($bloodBankId, $bloodBankName, $Address, $ContactNo,$districtId);
                    $status = $bloodBank->editBloodbank() ? 1 : 2;
                    // echo $campaign->getAddress();        

                } else {
                    //check status for valitations
                    $status = !$validateDates ? 3 : (!$validateName ? 4 : (!$validateAddress ? 5 : 6));
                }
            } else {
                //status for not valid token
                $status = "Unauthorzied Activity! ";
            }
        } else {
            //status for empty value
            $status = "All Fields need to be Filled!";
        }
    } else {
        //status for isset value
        $status = "All Fields need to be Filled!";
    }
} else {
//status for ivalid request method
    echo "Invalid request method";
}
//display the final status
echo $status;




