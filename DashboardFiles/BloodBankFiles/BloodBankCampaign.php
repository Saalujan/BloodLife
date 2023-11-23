<?php
require_once '../classes/campaign.php';
require_once '../classes/district.php';
require_once '../classes/bloodBank.php';



use classes\district;
use classes\campaign;
use classes\bloodBank;


$bankid = $user->getBloodBankId();
$bloodBank = new bloodBank($bankid, null, null, null, null);
$bloodBank->GetBloodbankData($bankid);

?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/Table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title></title>

    <style>
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

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
    <div class="mt-5 m-3 mb-1" style="color:gray;">
        <h5>Campaign</h5>
    </div>
   
    

    <div class="p-5">



       
        <div class="rounded-top-4 p-0 border border-dark-subtle">
            <div class="row align-items-center">
                <!-- Search input -->
                <div class="col-3">
                    <div class="input-group rounded p-3">
                        <input type="search" class="form-control rounded" placeholder="campaignID" aria-label="Search" oninput="searchfilter(this.value)" aria-describedby="search-addon">
                    </div>
                </div>






                <div class="col-3">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Date</option>
                        <option value="1">12/09/2023</option>
                        <option value="2">07/09/2023</option>
                        <option value="3">09/09/2023</option>
                    </select>
                </div>

                <div class="col-2">
                    <select class="form-select" aria-label="Default select example" oninput="DistrictFilter(this.value)">
                        <option selected value="">District</option>
                        <?php
                        $dataArray = district::getAllDistrict(); // Retrieve district data using the "getAllDistrict()" method

                        foreach ($dataArray as $district) {
                        ?>

                            <option value="<?php echo $district['district']; ?>"><?php echo $district['district']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                
                <div class="col-2">
                    <button type="button" class="btn btn-outline-primary" onclick="AddCampaign()"><strong> Add Campaign</strong> </button>





                </div><br>


                
                <!-- Table body -->
                <div class="container bg-white m-0 p-0" style=" max-height: 373px; overflow: scroll;">
                    <table class="table table-hover p-0">

                        <!-- Table row ----->


                        <!-- Campaign table Heading-->

                        <thead>
                            <tr class="sticky-top">
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">CampaignID</th>
                                <th class="col-2 bg-secondary text-dark p-2" style="text-align: center;">Name</th>
                                <th class="col-2 bg-secondary text-dark p-2" style="text-align: center;">StartDate</th>
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">EndDate</th>
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">Status</th>

                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">Edit</th>
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">Review</th>
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">View</th>
                            </tr>
                        </thead>

                        <!---Table body Details----------->


                        <table class="table">

                            <tbody id="output">
                                <?php
                              
                                $requestArray = campaign::getAllCampaign($user->getBloodBankId());
                                ?>

                                <script>
                                    let array = <?php echo json_encode($requestArray) ?>;
                                    let filterArray;
                                    showall(array);

                                    function showall(array) {
                                        const detailsList = document.getElementById("output");
                                        detailsList.innerHTML = "";
                                        if (array === null || array.length === 0) {
                                            var htmlCode = `<tr><td colspan="12" style="text-align: center;color: red;" >No Results Found</td></tr>`;
                                            detailsList.innerHTML = htmlCode;
                                        } else {
                                            array.forEach((item) => {

                                                var htmlCode = ` <tr>
                        <td class="col-1" style="text-align: center;">${item.campaignId}</td>
                        <td class="col-2" style="text-align: center;">${item.Title}</td>
                         <td class="col-2" style="text-align: center;">${item.startDate}</td>                    
                        <td class="col-1" style="text-align: center;">${item.endDate }</td>
                        <td class="col-1" style="text-align: center;">${item.status }</td>
                     
                       
                      
                    
                        <td class="col-1" style="text-align: center;"><i class="fas fa-edit fa-lg" style="color: #f21818;" data-bs-toggle="modal" data-bs-target="#EditCampaignDetailsModal" onclick="EditCamp(${item.campaignId})"></i></td>

                        <td class="col-1" style="text-align: center;"><i class="fa-solid fa-magnifying-glass fa-lg" onclick="ReviewChamp()"></i></td>

                        <td class="col-1" style="text-align: center;"> <a href="../Dashboards/BloodBankDashboard.php?page=CampaignView&&camid=${item.campaignId}" style="text-decoration: none;"><i class="fa-solid fa-eye fa-lg"></i></a></td>



                                                </tr>`;


                                                var divElement = document.createElement("tr");


                                                divElement.innerHTML = htmlCode;


                                                detailsList.appendChild(divElement);
                                            });
                                        };

                                    }

                                    function DistrictFilter(test) {
                                        if (test === "") {
                                            array = <?php echo json_encode($requestArray) ?>;
                                            showall(array);
                                        } else {
                                            array = <?php echo json_encode($requestArray) ?>;
                                            var testValue = test.toLowerCase();
                                            array = array.filter((item) => item.district.toLowerCase().includes(testValue));
                                            showall(array);
                                        }

                                    }

                                    function searchfilter(test) {

                                        var id = parseInt(test, 10);

                                        var testValue = test.toLowerCase();

                                        filterArray = array.filter((item) => item.campaignId === id || item.Title.toLowerCase().includes(testValue));


                                        const detailsList = document.getElementById("output");
                                        detailsList.innerHTML = "";
                                        if (filterArray === null || filterArray.length === 0) {
                                            var htmlCode = `<tr><td colspan="12" style="text-align: center;color: red;">No Results Found</td></tr>`;
                                            detailsList.innerHTML = htmlCode;
                                        } else {
                                            filterArray.forEach((item) => {

                                                var htmlCode = ` 
                            <tr>
                            <td class="col-1" style="text-align: center;">${item.campaignId}</td>
                        <td class="col-2" style="text-align: center;">${item.Title}</td>
                        
                        <td class="col-2" style="text-align: center;">${item.startDate}</td>                    
                        <td class="col-" style="text-align: center;">${item.endDate }</td>
                        <td class="col-1" style="text-align: center;">${item.review}</td>
                        <td class="col-1" style="text-align: center;">${item.status }</td>
                        <td class="col-1" style="text-align: center;">${item.districtId}</td>
                        <td class="col-1" style="text-align: center;"><i class="fas fa-edit fa-lg" style="color: #f21818;" data-bs-toggle="modal" data-bs-target="#EditCampaignDetailsModal" onclick="EditCamp(${item.campaignId})"></i></td>

                        <td class="col-1" style="text-align: center;"><i class="fa-solid fa-magnifying-glass fa-lg" onclick="ReviewChamp()"></i></td>

                        <td class="col-1" style="text-align: center;"> <a href="../Dashboards/BloodBankDashboard.php?page=CampaignView&&camid=${item.campaignId}" style="text-decoration: none;"><i class="fa-solid fa-eye fa-lg"></i></a></td>
                        </tr>`;


                                                var divElement = document.createElement("tr");


                                                divElement.innerHTML = htmlCode;


                                                detailsList.appendChild(divElement);

                                            });
                                        }


                                    }
                                </script>


                            </tbody>
                        </table>
                </div>

                <!-- Table Head -->


            </div>
        </div>

        <!-- Table -->
        <!-------------------------------------------->






        <!--CampaignAddDetails-->
        <!-- Modal -->
        <form action="../services/CampaignAddService.php" method="POST" enctype="multipart/form-data">


            <div class="modal fade" id="AddCampaign">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="AddCampaign"><span class="fw-bold">Campaign Details</span></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>Campaign Name</h6>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="Title" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            </div>


                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>start Date</h6>
                                </div>
                                <div class="col-9">
                                    <input type="date" name="startDate" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            </div>


                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>End Date</h6>
                                </div>
                                <div class="col-9">
                                    <input type="date" name="endDate" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            </div>


                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>Address</h6>
                                </div>
                                <div class="col-9">
                                    <input type="text " name="address" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            </div>


                            <div class="row align-items-center pb-3">
                                <div class="col-3">
                                    <h6>Location</h6>
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="district" class="form-control form-control-lg" id="district" onchange="functionTest(this.value)">
                                                <option>Select District</option>
                                                <?php


                                                $dataArray = district::getAllDistrict(); // Retrieve district data using the "getAllDistrict()" method

                                                foreach ($dataArray as $district) {
                                                ?>

                                                    <option value="<?php echo $district['district']; ?>"><?php echo $district['district']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6">

                                            <select name="division" class="form-control form-control-lg" id="divisionDropDown" onchange="getBloodBank(this.value)">
                                                <option>Select Division</option>

                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>



                        </div>

                        <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>


                        <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary"><strong>Add</strong></button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><strong>Cancel</strong></button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
            <!--CampaignAddDetails->















            <!-- Edit Campaign Modal -->
            <form action="../services/CampaignEditService.php" method="POST" enctype="multipart/form-data">
                <div class="modal fade" id="EditCampaignDetailsModal" tabindex="-1" role="dialog" aria-labelledby="EditCampaignDetailsLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="EditCampaignDetailsModal">Edit Campaign Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" >
                                <div id="campaignEdit"></div>
                                <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                
                            </div>
                           
                            
                           

                            <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-danger"><strong>Save</strong></button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><strong>Cancel</strong></button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>

           




            <!-- View Campaign Modal -->
            <form action="../services/CampaignViewService.php" method="POST" enctype="multipart/form-data">
            <div class="modal fade" id="ViewCampaignDetailsModal" tabindex="-1" role="dialog" aria-labelledby="ViewCampaignDetailsModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" id="ViewCampaignDetailsLabel">Edit Campaign Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        
                            <div class="modal-body" id="ViewCampaign">
                            

                                </div>


                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                    </div>
                </div>
              
            </form>

            
           




            <!--------------------------------------------------->
            <!-------------------Review-------------------------------->

            <div class="modal fade" id="Review" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="Review">Review Campaign</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Percentege</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=""><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>

                        </div>
                    </div>
                </div>
            </div>
            <script src="sweetalert2.all.min.js"></script>

            <?php
    
    ?>


</body>

</html>