<?php

require_once '../classes/bloodbankhsrequest.php';
require_once '../classes/validation.php';
require_once '../classes/User.php';

use classes\User;
use classes\validation;
use classes\bloodbankhsrequest;
//compare 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $status;

    

    if (isset($_POST["bloodGroup"], $_POST["bloodQuantity"], $_POST["requestStatus"], $_POST["token"] ,$_POST['hospitalRequestId'])) {


        if (!empty(($_POST["bloodGroup"]) && ($_POST["bloodQuantity"]) && ($_POST["requestStatus"]) && ($_POST["token"])) || ($_POST['hospitalRequestId'])) {

            //sanitize

            $bloodgroup = filter_var($_POST["bloodGroup"], FILTER_SANITIZE_STRING);
            $quantity = filter_var($_POST["bloodQuantity"], FILTER_SANITIZE_STRING);
            $requestStatus = filter_var($_POST["requestStatus"], FILTER_SANITIZE_STRING);
            $token = filter_var($_POST["token"], FILTER_SANITIZE_STRING);
            $hospitalRequestId = filter_var($_POST["hospitalRequestId"],FILTER_SANITIZE_NUMBER_INT);
            

            //validate
            $user = new User(null, null, null, null, $token, null, null, null, null);


            $validatebloodgroup = validation::validateBloodGroup($bloodgroup);
            $validatequantity = validation::validatequantity($quantity);
            $validateToken = $user->validateToken();
            $bloodBankId = $user->getBloodBankId();

            $createdDate = date("Y-m-d");

            if ($validateToken && $bloodBankId != null) {

                if ($validatebloodgroup && $validatequantity) {

                    if($hospitalRequestId==null){
                        $request = new bloodbankhsrequest(null, $createdDate, $quantity,$bloodgroup, $requestStatus, null, $bloodBankId);
                        $status = $request->addbloodbankRequest() ? 1 : "Bloodbank Request did not Added! Try Again..";

    
                    }else{
                        $request = new bloodbankhsrequest(null, $createdDate, $quantity,$bloodgroup, $requestStatus,$hospitalRequestId, $bloodBankId);
                        if(!$request->ValidatePublishRequest()){
                        $status = $request->addbloodbankRequest() ? 1 : "An Error occurred While Publishing the Hospital Request. Please Try Again!" ;
                        
                        }else{
                            $status = "Request Already Published! ";
                        }
                    }


                    
                } else {
                    $status = !$validatebloodgroup ? "Blood Group type Error!" : (!$validatequantity ? "Quantity must have 3 digits!": "Quantity must have 3 digits!");
                }
            } else {
                $status = "Unauthorzied Activity! ";
            }
        } else {
            $status = "All Fields need to be Filled!";
        }
    } else {
        $status = "All Fields need to be Filled!";
    }  
} else {
    $status = "Invalid Request Method!";
}

$encrptedmessage=validation::encryptedValue($status);
header("Location: ../Dashboards/BloodBankDashboard.php?bhreqid=$hospitalRequestId&status=$encrptedmessage");
