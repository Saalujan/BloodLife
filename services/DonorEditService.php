<?php

namespace classes;

require_once '../classes/Donor.php';
require_once  '../classes/district.php';
require_once '../classes/Validation.php';

use classes\district;
use classes\Donor;
use classes\Validation;

$status = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset(
        $_POST["name"],
        $_POST["bloodGroup"],
        $_POST["nic"],
        $_POST["contactNumber"],
        $_FILES["medicalReport"],
        $_POST["donorId"],
        $_POST["availability"],
        $_POST["token"]
    )) {

        //empty value check
        if (
            !empty($_POST["name"]) && ($_POST["bloodGroup"])  &&
            ($_POST["nic"]) && ($_POST["contactNumber"]) && ($_FILES["medicalReport"])  && ($_POST["token"]) && ($_POST["donorId"]) && ($_POST["availability"])
        ) {

            // sanitizing the inputs
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $bloodGroup = filter_var($_POST['bloodGroup'], FILTER_SANITIZE_STRING);
            $bloodGroup = filter_var($_POST['bloodGroup'], FILTER_SANITIZE_STRING);
            $contactNumber = filter_var($_POST['contactNumber'], FILTER_SANITIZE_STRING);
            $nic = filter_var($_POST['nic'], FILTER_SANITIZE_STRING);
            $medicalReport = file_get_contents($_FILES['medicalReport']['tmp_name']);
            $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);


            //create user object with token
            $user = new User( null, null, null, null, $token, null, null, null, null);

            //validations


            $validatePhoneNumber = Validation::validateContactNumber($contactNumber);
            $validateNic = Validation::validateSriLankanNIC($nic);
            $validateBloodGroup = Validation::validateBloodGroup($bloodGroup);
            $validateToken = $user->validateToken();
            $bloodBankId = $user->getBloodBankId();

            //token and bloodbank id checking
            if ($validateToken && $bloodBankId != null) {


                //email,phonenumber,nic,dob,bloodgroup valitaion check
                if ($validatePhoneNumber && $validateNic && $validateBloodGroup) {

                    //nic,email,username exist check in db



                    //create donor object
                    $donor = new Donor($user->getDonorId(), null, null, null, null, null, null, null, null, null, null, null, null, null);
                    $donor->getDonorDetails();

                    $donor->setName($name);
                    $donor->setAvailability($Available);
                    $donor->setMedicalReport($medicalReport);
                    $donor->setContactNumber($contactNumber);
                    $donor->setNic($nic);
                    $donor->setDistrictId($districtId);


                    if ($donor->EditDonor()) {
                        $status = 1;
                    } else {
                        $status = "Donor Edited Failed";
                    }
                } else {
                    //check status for valitations
                    $status = !$validateEmail ? 12 : (!$validatePhoneNumber ? 13 : (!$validateNic ? 14 : (!$validateDob ? 15 : (!$validateBloodGroup ? 16 : 17))));
                }
            } else {
                //status for not valid token
                $status = 18;
            }
        } else {
            //status for empty value
            $status = 19;
        }
    } else {
        //status for isset value
        $status = 20;
    }
} else {

    echo "Invalid request method";
}

echo $status;
