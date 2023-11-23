<?php
require_once '../classes/Bloodtable.php';
require_once '../classes/validation.php';
require_once '../classes/User.php';
require_once '../classes/hospitalrequestbloodbank.php';

use classes\User;
use classes\Bloodtable;
use classes\validation;
use classes\Hospitalrequestbloodbank;

$status;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["bloodId"], $_POST["HosReqId"], $_POST["token"])) {
        if (!empty($_POST["bloodId"] && $_POST["HosReqId"] && $_POST["token"])) {
            $bloodId = $_POST["bloodId"];
            $token = $_POST["token"];
            $HosPeqId = $_POST["HosReqId"];
            $user = new User(null, null, null, null, $token, null, null, null, null);
            $validateToken = $user->validateToken();
            $bloodBankId = $user->getBloodBankId();
            if ($validateToken && $bloodBankId != null) {
                foreach ($bloodId as $id) {
                    $bloodpackets = new Bloodtable($id, null, null, null, null, null);
                    $bloodpackets->GetBloodpacketsData();
                    $bloodpackets->setStatus("Given");
                    $hosReqAccept = new Hospitalrequestbloodbank(null, $HosPeqId, $bloodBankId, $bloodId);
                    if ($hosReqAccept->AddHospitalReqAccept()) {
                        if ($bloodpackets->Editbloodpacket()) {
                            $status = 1;
                        } else {
                            $status = 2;
                        }
                    }
                }
                $status = 5;
            } else {
                $status = 6;
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
$encrptedmessage = validation::encryptedValue($status);
// header("Location: ../Dashboards/BloodBankDashboard.php?page=bloodBankHospital&status=$encrptedmessage");
