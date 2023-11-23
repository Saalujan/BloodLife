<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php


require_once '../classes/Donor.php';
require '../classes/district.php';
require_once '../classes/bloodBank.php';

use classes\district;
use classes\bloodBank;
use classes\Donor;


$bankid = $user->getBloodBankId();
$bloodBank = new bloodBank($bankid, null, null, null, null);
$bloodBank->GetBloodbankData($bankid);

?>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
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

    

    <!-- Navigation Bar -->
   

    <!-- Body Content -->
    <div class="mt-5 m-3 mb-1" style="color: gray;">
        <h5>Donor</h5>
        <div class="row align-items-right justify-content-center">
            <img class="d-none d-xl-block" src="../Images/donor.jpg" style="height: 150px; width: 700px; align-items: center;" />
        </div>
    </div>

    <!-- Page Content Container -->
    <div class="container p-2">

        <!-- Search and Add Donor Section -->
        <div class="row bg-white  align-items-center justify-content-center rounded-3" style="height: 300px;">
            <div class="container">
                <div class="rounded-top-4 p-0 border border-dark-subtle">
                    <div class="row align-items-center">

                        
                        <!-- Search input -->
                        <div class="col-3">
                            <div class="input-group rounded p-3">
                            <input type="search" class="form-control rounded" placeholder="DonorID" aria-label="Search" oninput="searchIdNamefilter(this.value)" aria-describedby="search-addon">
                            </div>
                        </div>

                        <!-- Blood Group filter -->
<div class="col-2">
    <select class="form-select" aria-label="BloodGroup" onchange="BloodGrpFilter(this.value)">
        <option selected disabled>BloodGroup</option>
        <option value="A+">A+</option>
        <option value="B+">B+</option>
        <option value="O+">O+</option>
        <option value="AB+">AB+</option>
        <option value="A-">A-</option>
        <option value="B-">B-</option>
        <option value="AB-">AB-</option>
        <option value="O-">O-</option>
    </select>
</div>


                        <!-- Add Donor button -->
                       

                <!-- Donor table -->



                






                <!-- Table body -->
                <div class="container bg-white m-0 p-0" style=" max-height: 373px; overflow: scroll;">
                    <table class="table table-hover p-0">

                        <!-- Table row ----->


                        <!-- Campaign table Heading-->

                        <thead>
                            <tr class="sticky-top">
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">DonorID</th>
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">Name</th>
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">Blood Group</th>
                                <th class="col-2 bg-secondary text-dark p-2" style="text-align: center;">Contact No</th>
                               <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">Available</th>
                       
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">Edit</th>
                                <th class="col-1 bg-secondary text-dark p-2" style="text-align: center;">View</th>
                            </tr>
                        </thead>

                        <!---Table body Details----------->


                        <table class="table">

                            <tbody id="output">
                                <?php
                             
                                $requestArray = Donor::getAllDonor($user->getBloodBankId());
                                foreach ($requestArray as &$item) {
                                    $item['medicalReport'] = base64_encode($item['medicalReport']);
                                    $item['image'] = base64_encode($item['image']);
                                }
                            
                                ?>

                                <script>
                                    let array = <?php echo json_encode($requestArray); ?>;
                                    console.log(array);
                                    console.log("Asath");
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
                        <td class="col-1">${item.donorId}</td>
                        <td class="col-1">${item.name}</td> 
                        <td class="col-1">${item.bloodGroup }</td>
                        
                         <td class="col-2">${item.contactNumber}</td>                    
                        <td class="col-1">${item.availability }</td>
                       
                     
                       
                      
                        
                        <td class="col-1"><i class="fas fa-edit fa-lg" style="color: #f21818;" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="EditDon(${item.donorId})"></i> </td>
                        
                        <td class="col-1"><i class="fa-solid fa-eye fa-lg" style="color: #f00040a;" data-bs-toggle="modal" data-bs-target="#DonorView" onclick="ViewDon(${item.donorId})"></i></td>
                        


                                                </tr>`;


                                                var divElement = document.createElement("tr");


                                                divElement.innerHTML = htmlCode;


                                                detailsList.appendChild(divElement);
                                            });
                                        };


                                    }


                                    function BloodGrpFilter(test) {
                                        if (test === "") {
                                            array = <?php echo json_encode($requestArray) ?>;
                                            showall(array);
                                        } else {
                                            array = <?php echo json_encode($requestArray) ?>;
                                            var testValue = test.toLowerCase();
                                            array = array.filter((item) => item.bloodGroup.toLowerCase().includes(testValue));
                                            showall(array);
                                        }

                                    }

                                    function searchIdNamefilter(test) {

                                        var id = parseInt(test, 10);

                                        var testValue = test.toLowerCase();

                                        filterArray = array.filter((item) => item.donorId === id || item.name.toLowerCase().includes(testValue));


                                        const detailsList = document.getElementById("output");
                                        detailsList.innerHTML = "";
                                        if (filterArray === null || filterArray.length === 0) {
                                            var htmlCode = `<tr><td colspan="12" style="text-align: center;color: red;">No Results Found</td></tr>`;
                                            detailsList.innerHTML = htmlCode;
                                        } else {
                                            filterArray.forEach((item) => {

                                                var htmlCode = ` 
                            <tr>
                            <td class="col-1">${item.donorId}</td>
                        <td class="col-1">${item.name}</td> 
                        <td class="col-1">${item.bloodGroup }</td>
                        
                         <td class="col-2">${item.contactNumber}</td>                    
                        <td class="col-1">${item.availability }</td>
                        
                        
                        <td class="col-1"><i class="fas fa-edit fa-lg" style="color: #f21818;" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="EditDon(${item.donorId})"></i> </td>
                        
                        <td class="col-1"><i class="fa-solid fa-eye fa-lg" style="color: #f00040a;" data-bs-toggle="modal" data-bs-target="#DonorView" onclick="ViewDon(${item.donorId})"></i></td>
                        
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

                </table>
            </div>
        </div>
    </div>
    </div>












    <!----------------------------EditDonorDtails------------------------------------------------------------------------------->
    <!-- Modal -->
    <form action="../services/DonorEditService.php" method="POST" enctype="multipart/form-data">
        <!--<form name="donorForm" action="../services/DonorAddService.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
            <!-- Your form content here -->



        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModal">Donor Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div id="EditDonor"></div>
                        <?php echo $token; ?>
                        <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>

                        <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-danger"><strong>Edit Donor</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </form>
    <!--AddDonorDetails---------------------------------------------------------->













    <!-- --------------------------------------Donor View----------------------------------------------------------------------- -->
    <!-----------1st pop-up------------------------Campaign Details---------------->
    <div class="modal fade" id="DonorView">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="DonorView">View Donor Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                <div id="ViewDonor"></div> 
                </div>




                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
    <!--Camp Edit-->



    
        <?php



        ?>

</body>

</html>