<?php
require_once "../classes/hospitalrequestclass.php";
require_once "../classes/Validation.php";
require_once '../classes/bloodBank.php';


use classes\hospitalrequestclass;
use classes\Validation;
use classes\bloodBank;



$bankid = $user->getBloodBankId();
$bloodBank = new bloodBank($bankid, null, null, null, null);
$bloodBank->GetBloodbankData($bankid);




if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["bhreqid"]) || isset($_GET["status"])) {
        $BReqId = $_GET["bhreqid"];
      

        ?>
        <!DOCTYPE html>
        <!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
        <html>

        <head>
            <meta charset="UTF-8">
            <title></title>
            <link rel="stylesheet" href="../CSS/BloodBankHSRequest.css">
        </head>

        <body>

        <div class="sticky-top bg-white shadownav" style="height: 50px;">
                <div class="row m-0 d-flex">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                        <div class="row align-items-center justify-content-end">
                         
                            <div class="col-6 mt-2 	d-none d-xl-block ">
                                <b><?php echo $bloodBank->getBloodBankName();  ?></b>
                                <p style="font-size: 10px;">Blood Bank</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- nav bar end -->

            <!-- body start -->
            <?php
        if (!empty($_GET["status"])) {
            $status = Validation::decryptedValue($_GET["status"]);
            if ($status == 1) {
?>

                <div class="alert alert-success d-flex align-items-center m-3" role="alert">
                    <div class="col-1 align-items-center justify-content-center">
                        <img width="30" height="30" src="https://img.icons8.com/color/48/ok--v1.png" alt="ok--v1" />
                    </div>
                    <div class="col-10 d-flex">
                        Request Successfully Added
                    </div>

                    <div class="col-1 d-flex align-items-end justify-content-center">
                        <a href="../Dashboards/BloodBankDashboard.php?bhreqid=<?php echo $BReqId?>"> <img width="30" height="30" src="https://img.icons8.com/hatch/64/delete-sign.png" alt="delete-sign" /></a>
                    </div>

                </div>
            <?php
            } else {


            ?>

                <div class="alert alert-danger d-flex align-items-center m-3" role="alert">
                    <div class="col-1 align-items-center justify-content-center">
                        <img width="30" height="30" src="https://img.icons8.com/cute-clipart/64/high-priority.png" alt="high-priority" />
                    </div>
                    <div class="col-10 d-flex">
                        <?php
                        echo $status;
                        ?>
                    </div>

                    <div class="col-1 d-flex align-items-end justify-content-center">
                        <a href="../Dashboards/BloodBankDashboard.php?bhreqid=<?php echo $BReqId?>"> <img width="30" height="30" src="https://img.icons8.com/hatch/64/delete-sign.png" alt="delete-sign" /></a>
                    </div>

                </div>

        <?php
            }
        }

        ?>
            <div class="mt-5 m-3 mb-1" style="color:gray;">
                <h5>Hospital Request View</h5>
            </div>
            <div class="row bg-white m-3 pt-0  align-items-center justify-content-center rounded-5" style="height: 600px;">



                <?php

                if (hospitalrequestclass::getRequestwithHospitalusingID($BReqId) != false) {
                    $requestObj = hospitalrequestclass::getRequestwithHospitalusingID($BReqId);


                ?>






                    <div class="row">
                        <div class="col-lg-5 m-3 p-1">

                            <div class="form-container" style=" border: 2px solid #ccc; border-radius:10px; width: 500px">

                                <form action="../services/Addbloodbankrequest.php" method="POST">
                                    <div class="col m-2">
                                        <div class="form-group">
                                            <label for="blood-group">Blood Group</label>
                                            <input type="text" name="bloodGroup" value="<?php echo $requestObj["bloodGroup"]; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" name="bloodQuantity" value="<?php echo $requestObj["bloodQuantity"] ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <input type="text" name="requestStatus" value="<?php echo $requestObj["requestStatus"]  ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="hospital-id">HospitalRequest ID</label>
                                            <input type="text" name="hospitalRequestId" value="<?php echo $requestObj["hospitalRequestID"]; ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="available-quantity">Available Quantity</label>
                                            <?php $hRequest = new hospitalrequestclass(null, null, null, $requestObj["bloodGroup"], null, null); ?>

                                            <input type="number" value="<?php echo $hRequest->totalQuantityarrayByBloodGroup($bankid) ?>" name="available quantity" id="available-quantity" readonly>
                                        </div>

                                        <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                        <div class="text-end"><br>
                                            <div class="buttons">
                                                <a href="../Dashboards/BloodBankDashboard.php?page=bbraa&HosReq=<?php echo validation::encryptedValue($requestObj["hospitalRequestID"]); ?>&bloodGroup=<?php echo validation::encryptedValue($requestObj["bloodGroup"]); ?>"> <button type="button" class="btn btn-outline-secondary"><strong> Accept </strong></button></a>
                                                <button type="sumbit" class="btn btn-outline-danger"><strong>Publish </strong></button>

                                            </div><br>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 justify-content-center align-items-center text-center">
                            <img class="d-none d-lg-block w-100 text-center" src="https://creazilla-store.fra1.digitaloceanspaces.com/cliparts/35517/blood-donation-clipart-md.png" />
                        </div>
                    </div>


            </div>


<?php
                } else {
                    echo "detail not found";
                }
            } else {
                echo "ID not found in the URL.";
            }
        } else {
            echo "ID not found in the URL.";
        }
?>

        </body>

        </html>