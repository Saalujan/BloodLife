<?php


require_once '../classes/hospitalrequestclass.php';
require_once '../classes/Validation.php';

require_once '../classes/hospital.php';

require_once '../classes/hospitalrequestbloodbank.php';


use classes\hospital;
use classes\hospitalrequestclass;
use classes\Validation;
use classes\Hospitalrequestbloodbank;


$hospitalid = $user->getHospitalId();
$hospital = new hospital($hospitalid, null, null, null, null);
$hospital->GetHospitalData($hospitalid);

// Check if the 'hospitalRequestID' parameter is set in the URL
if (isset($_GET['hreqid'])) {
    // Retrieve and store the 'hospitalRequestID' value
    $id = Validation::decryptedValue($_GET['hreqid']);
    $HospitalReqAccept = new Hospitalrequestbloodbank(null, $id, null, null);



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
                                <b><?php echo $hospital->getName();  ?></b>
                                <p style="font-size: 10px;">Hospital</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- nav bar end -->





        <?php
        if (hospitalrequestclass::getRequestwithHospitalusingID($id) != false) {
            $datAarray = hospitalrequestclass::getRequestwithHospitalusingID($id);


        ?>


            <div class="row bg-white m-3 pt-0  align-items-center justify-content-center rounded-5" style="height: 900px;">
            <div class="row">
                <div class="col-6 align-items-center justify-content-center">
                    <img class="d-none d-xl-block" src="../Images/blood-donor-nurse_74855-6262.jpg" />
                </div>
                <div class="col-lg-6">
                    <div class="row form-container mb-4 align-items-center justify-content-center" style="height: 75px;width: 500px;color:<?php echo $HospitalReqAccept->GetCountOfAcceptBloodBnk() == 0 ? "red" : "green"; ?>">
                        <div class="col-1 align-items-center justify-content-center align-self-center">
                            <?php echo $HospitalReqAccept->GetCountOfAcceptBloodBnk() == 0 ?
                                '<img width="30" height="30" src="https://img.icons8.com/external-others-inmotus-design/67/external-Accept-round-icons-others-inmotus-design-4.png" alt="external-Accept-round-icons-others-inmotus-design-4"/>' :
                                '<img width="30" height="30" src="https://img.icons8.com/fluency/48/checked.png" alt="checked"/>'; ?>

                        </div>
                        <div class="col-7 text-start">
                            <h6 style="font-weight: bold;font-size: 14px;">Count Of accepted Blood Packets</h6>
                        </div>
                        <div class="col-4 text-end">
                            <h2 style="font-weight: bold;"><?php echo $HospitalReqAccept->GetCountOfAcceptBloodBnk(); ?></h2>
                        </div>
                    </div>
                    <div class="row form-container mb-4 align-items-center justify-content-center" style="height: 75px;width: 500px;color:<?php echo $HospitalReqAccept->GetCountOfAcceptBloodBnk() == 0 ? "red" : "green"; ?>">
                        <div class="col-1">
                            <img width="30" height="30" src="https://img.icons8.com/arcade/64/drop-of-blood.png" alt="drop-of-blood" />
                        </div>
                        <div class="col-7 text-start">
                            <h6 style="font-weight: bold;font-size: 14px;">Accpeted Quantity</h6>
                        </div>
                        <div class="col-4 text-end">
                            <h2 style="font-weight: bold;"><?php echo $HospitalReqAccept->GetCountOfAcceptBloodQuantity() != 0 ? $HospitalReqAccept->GetCountOfAcceptBloodQuantity() . " ml" : "0 ml" ?></h2>
                        </div>
                    </div>
                    <div class="row form-container" style="width: 500px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="mb-0"><span class="fw-bold">BloodGroup</span></p>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="bloodGroup" value="<?php echo $datAarray["bloodGroup"]; ?>" readonly>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="mb-0"><span class="fw-bold">Date</span></p>
                                </div>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" name="date" value="<?php echo $datAarray["createdDate"]; ?>" readonly>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="mb-0"><span class="fw-bold">Blood Quantity</span></p>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="bloodQuantity" value="<?php echo $datAarray["bloodQuantity"]; ?>" readonly>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="mb-0"><span class="fw-bold">Status</span></p>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="requestStatus" value="<?php echo $datAarray["requestStatus"]; ?>" readonly>
                                </div>
                            </div>
                            <hr>

                        </div>
                        <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                        <div class="text-end">
                            <a href="HospitalDashboard.php?page=hospitalreqedit&&hreqid=<?php echo $_GET['hreqid']; ?>" style="text-decoration: none;color: black"> <button class="btn btn-outline-danger"><strong>Edit</strong></button></a>
                        </div>


                    </div>
                    <div class=" row bg-white form-container mt-4 align-items-center justify-content-center" style=" box-shadow: rgba(0, 0, 0, 0.16) 0px 2px 15px; width:800px !important; min-height:200px; max-height:400px; overflow: scroll;">
                    <div class="col">
                        
                            <table class="table table-hover p-0">
                                <tr class="sticky-top">


                                    <th class="col-5 bgcol p-2 " style="text-align: center;">Blood Bank Name</th>
                                    <th class="col-3 bgcol p-2" style="text-align: center; ">Phone Number</th>
                                    <th class="col-2 bgcol p-2" style="text-align: center; ">Address</th>





                                </tr>

                              

                                <tbody id="output">
                                <?php $detailsArray = $HospitalReqAccept->GetAcceptedBloodBankDetail();
                                    foreach ($detailsArray as $Bank) { ?>
                                    <tr> 
                                        <td class="col-5 bgcol p-2" style="text-align: center;"><?php echo $Bank["bloodBankName"]?> </td>
                                 
                                        <td class="col-2 bgcol p-2" style="text-align: center;"><?php echo $Bank["ContactNo"]?> </td>
                                    
                                        <td class="col-5 bgcol p-2" style="text-align: center;"><?php echo $Bank["Address"]?> </td>
                                    </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                       
                        </div>
                    </div>
                    </div>
                   
                    
           
                    </div>
                
            

            

        







            <!-- check boxes -->






























    <?php
            // Now, you can use the $id variable in your code
        } else {
            echo "Detail Not Found";
        }
    } else {
        echo "ID not found in the URL.";
    }

    ?>
    </body>

    </html>