
<?php

require_once '../classes/User.php';
require_once '../classes/Validation.php';
require_once '../classes/district.php';
require_once '../classes/bloodBank.php';
require_once '../classes/Donor.php';

use classes\User;
use classes\Validation;
use classes\district;
use classes\bloodBank;
use classes\Donor;

header('Content-Type: application/json');

$method = $_SERVER["REQUEST_METHOD"];

$headers = getallheaders();
$authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : (isset($headers['authorization']) ? $headers['authorization'] : null);


if ($method === "POST") {
     $data = json_decode(file_get_contents("php://input"), true);
    if (isset($authorizationHeader) && preg_match('/Bearer\s+(.*)$/i', $authorizationHeader, $matches)) {

        $token = $matches[1];
        $user = new User(null, null, null, null, $token, null, null, null, null);

        if ($user->validateToken() && $user->getDonorId() != null) {
            if (isset($data["name"], $data["nic"], $data["contactNumber"],
                            $data["district"], $data["division"],$data["availability"])) {

                //empty value check
     

                    // sanitizing the inputs
                    $name = filter_var($data["name"], FILTER_SANITIZE_STRING);
                    $Available = filter_var($data["availability"], FILTER_SANITIZE_STRING);
                
                    $contactNumber = filter_var($data["contactNumber"], FILTER_SANITIZE_STRING);
                    $nic = filter_var($data["nic"], FILTER_SANITIZE_STRING);
                    $district = filter_var($data["district"], FILTER_SANITIZE_STRING);
                    $division = filter_var($data["division"], FILTER_SANITIZE_STRING);
                    $districtId = district::getDistrictIDDD($district, $division);

            
                    
               

                        //create donor object
                        $donor = new Donor($user->getDonorId(), null, null, null, null, null, null, null, null, null, null, null, null, null);
                        $donor->getDonorDetails();
                 
                        $donor->setName($name);
                        $donor->setAvailability($Available);
                       
                        $donor->setContactNumber($contactNumber);
                        $donor->setNic($nic);
                        $donor->setDistrictId($districtId);
                       

                        if ($donor->EditDonor()) {
                            $status = true;
                        } else {
                            $status = "Donor Edited Failed";
                        }
                
              
            } else {
                //status for isset value
                $status = "Need All Inputs";
            }
        } else {
             $status = "Un Authorized";
        }
    }else{
        $status = "Header Isseu";
    }
    echo json_encode(array("message" => $status));
} else {
    echo json_encode(array("message" => "Invalid request method."));
}