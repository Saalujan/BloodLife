<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace classes;

require_once '../classes/Campaign.php';
require_once  '../classes/district.php';
require_once  '../classes/User.php';
require_once  '../classes/Validation.php';
use classes\district;
use classes\campaign;
use classes\User;
use classes\Validation;


// $districtId = filter_var($_POST['districtId'],FILTER_SANITIZE_NUMBER_INT);
// $organizerId  =filter_var( $_POST['organizerId'],FILTER_SANITIZE_NUMBER_INT);
//$bloodBankId = filter_var($_POST['bloodBankId'],FILTER_SANITIZE_NUMBER_INT);

//$districtId = district::getDistrictIDDD($district, $division);
//echo $campaignId  ;


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset(
        $_POST["Title"],
        $_POST["address"],
        $_POST["startDate"],
        $_POST["endDate"],
        $_POST["district"],
        $_POST["division"],
        $_POST["token"],
    )) {

        //empty value check
        if (
            !empty($_POST["Title"]) && ($_POST["address"]) && ($_POST["startDate"]) &&
            ($_POST["endDate"])  &&
            ($_POST["district"]) && ($_POST["division"]) && ($_POST["token"])
        ) {

            // sanitizing the inputs

            $Title = filter_var($_POST['Title'], FILTER_SANITIZE_STRING);
            $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
            $startDate = filter_var($_POST['startDate'], FILTER_SANITIZE_STRING);
            $endDate = filter_var($_POST['endDate'], FILTER_SANITIZE_STRING);
            $district = filter_var($_POST['district'], FILTER_SANITIZE_STRING);
            $division = filter_var($_POST['division'], FILTER_SANITIZE_STRING);
           $token= filter_var($_POST['token'], FILTER_SANITIZE_STRING);




            //create user object with token
            $user = new User( null, null, null, null, $token, null, null, null, null);

            //validations
           $validateName = Validation::validateLettersLength($Title,6);
           $validateAddress = Validation::validateLettersLength($address,6);
            $validateDates = Validation::validateChamDate($startDate, $endDate);
            $districtId = district::getDistrictIDDD($district,$division);

            $validateToken = $user->validateToken();
            $bloodBankId = $user->getBloodBankId();

            //token and bloodbank id checking
            if ($validateToken && $bloodBankId != null) {


                //email,phonenumber,nic,dob,bloodgroup valitaion check
                if ($validateDates   && $validateName &&   $validateAddress ) {
                  

                        //create Campign object
                        $campaign  = new campaign(null, $Title, $address, $startDate, $endDate,null, "Active", $districtId, $bloodBankId);
                        $status = $campaign->AddCampaign() ? 1 : "Campaign Did not Registered! Try Again..";          
              
                } else {
                    //check status for valitations
                    $status = !$validateDates ? "Date Format Error!" : (!$validateName ? "Campaign Name Format Error!"  : (!$validateAddress ? "Address Format Error!" : "Address Format Error!"));
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

    echo "Invalid request method";
}

echo $status;


