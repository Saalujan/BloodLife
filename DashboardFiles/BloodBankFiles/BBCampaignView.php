<?php
require_once '../classes/Campaign.php';
require_once  '../classes/district.php';
require_once "../vendor/autoload.php";


use classes\district;
use classes\campaign;
use classes\bloodbankhsrequest;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;




if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["camid"])) {
        $campaignId = filter_var($_GET["camid"], FILTER_SANITIZE_NUMBER_INT);
        $campaign = new campaign($campaignId, null, null, null, null, null, null, null, null);
        if ($campaign->getCampaignDetails()) {
            $districtId = $campaign->getDistrictId();
            $rs = district::getDistrictDivisionById($districtId);



?>


            <html>

            <body>
                <!-- nav bar start -->
                <div class="sticky-top bg-white shadownav" style="height: 50px;">
                    <div class="row m-0 d-flex">
                        <div class="col-8">

                        </div>


                        <div class="col-4">
                            <div class="row align-items-center">
                                <div class="col-2 mb-2">

                                </div>
                                <div class="col-2 mb-2">

                                </div>
                                <div class="col-2 mb-2">

                                </div>
                                <div class="col-6 mt-2 	d-none d-xl-block">
                                    <b>Jaffna Blood Bank</b>
                                    <p style="font-size: 10px;">Blood Bank</p>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <!-- nav bar end -->

                <div class="mt-5 m-3 mb-1" style="color:gray;">

                    <h5>Campaign-view</h5>
                </div>






                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong> CampaignName</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-0" name="EditTitle"><?php echo $campaign->getTitle(); ?></p>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Start Date</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-0" name="startDate"> <?php echo $campaign->getstartDate(); ?>"</p>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>End Date</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-0" name="endDate"> <?php echo $campaign->getendDate(); ?>"</p>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Address</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-0"><?php echo $campaign->getAddress(); ?></p>
                                        </div>

                                        <div class="row align-items-center pb-3">

                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-sm-4">
                                                <strong>District</strong>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="text-muted mb-0" name="startDate"><?php echo $rs['district']; ?></p>
                                            </div>
                                            <div class="row align-items-center pb-3">

                                            </div>


                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <strong>Division</strong>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="text-muted mb-0" name="startDate"><?php echo $rs['division']; ?></p>
                                                </div>

                                                <div class="row align-items-center pb-3">
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-sm-4">
                                                        <strong>Status</strong>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <p class="text-muted mb-0"><?php echo $campaign->getStatus(); ?></p>
                                                    </div>
                                                    <div class="row align-items-center pb-3">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <?php
$data = 

                            $result = Builder::create()
                                ->writer(new PngWriter())
                                ->writerOptions([])
                                ->data("campaign" . $campaignId)
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












    <?php
        } else {
        }
    } else {
    }
} else {
}



    ?>
            </body>

            </html>