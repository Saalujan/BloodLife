<?php
require_once "../classes/bloodbankhsrequest.php";
require_once "../vendor/autoload.php";
require_once '../classes/Validation.php';
require_once '../classes/bloodBank.php';

use classes\bloodbankhsrequest;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use classes\Validation;
use classes\bloodBank;



$bankid = $user->getBloodBankId();
$bloodBank = new bloodBank($bankid, null, null, null, null);
$bloodBank->GetBloodbankData($bankid);


if ($_SERVER["REQUEST_METHOD"] == "GET") { 
    if (isset($_GET["breqId"])) {
        $BReqId = $_GET["breqId"];
        $BBRequest = new bloodbankhsrequest($BReqId, null, null, null, null, null, null);
        $Result = $BBRequest->getBloodBankReqByReqID();

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
            <link rel="stylesheet" href="../../CSS/BloodBankHospitalRequestView.css">
        </head>

        <body>
            <!-- nav bar start -->
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



            <div class="mt-5 m-3 mb-1" style="color:gray;">
                <h5>Request View</h5>
            </div>
            <div class="row bg-white m-3 pt-0  " style="height: 600px;">

                <div class="col-lg-5 m-2">
                    <div class="form-container" style="margin-left:20px;width: 500px">
                <div class="col-lg-5 m-2">
                    <div class="form-container" style="margin-left:20px;width: 500px">
                        <div class="card-body">

                            <br>

                            <div class="row">
                                <div class="col-sm-6">
                                    <strong> Blood Bank Request ID</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo "B" . $Result->bloodBankRequestId; ?>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-6">
                                    <strong> Blood Quantity</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $Result->bloodQuantity; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong> Blood Group</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $Result->bloodGroup; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Hospital Name</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $Result->hospitalName; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Hospital Address</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $Result->hospitalAddress; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong> hospital Request Id</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $Result->hospitalRequestId; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong> Created Date</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $Result->createdDate; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Status:</strong>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $Result->requestStatus; ?>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5 m-2 p-3 align-items-center justify-content-center text-center p-4" style="height: 480px; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; margin-left:80px">
 <?php


                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->writerOptions([])
                    ->data("bloodbank" . $Result->bloodBankRequestId)
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                    ->size(300)
                    ->margin(10)
                    ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                    ->labelText('Scan the Qr')
                    ->validateResult(false)
                    ->build();




                // Get the image data as a string
                $imageData = $result->getString();

                // Encode the image data as a base64 string
                $base64 = base64_encode($imageData);

                // Output the base64 string within an img tag
                echo '<img src="data:image/png;base64,' . $base64 . '" alt="QR Code">';
                ?>



            </div>
            </div>


            


            </div>

            </div>



    <?php

    }
}

    ?>
        </body>

        </html>