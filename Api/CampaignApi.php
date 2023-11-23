<?php

require_once '../classes/campaign.php';
require_once '../classes/User.php';

use classes\campaign;
use classes\User;


header('Content-Type: application/json');

$method = $_SERVER["REQUEST_METHOD"];

$headers = getallheaders();
$authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : (isset($headers['authorization']) ? $headers['authorization'] : null);


if ($method === "GET") {
    if (isset($authorizationHeader) && preg_match('/Bearer\s+(.*)$/i', $authorizationHeader, $matches)) {

        $token = $matches[1];
        $user = new User(null, null, null, null, $token, null, null, null, null);

        if ($user->validateToken() && $user->getDonorId() != null) {


            $Allcamp = campaign::getAllCampaigns();

            if ($Allcamp == null) {

                echo json_encode(array("message" => "Donor Didn't found"));
            } else {

                echo json_encode(array("message" => true, "data"=>$Allcamp));
            }
        } else {
            
            echo json_encode(array("message" => "Invalid Token"));
        }
    } else {
        echo json_encode(array("message" => "Didn't Find Header"));
    }
} else {
    echo json_encode(array("message" => "Invalid request method."));
}
