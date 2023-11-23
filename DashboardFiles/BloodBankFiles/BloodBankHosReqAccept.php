<?php

require_once "../classes/hospitalrequestclass.php";
require_once "../classes/Validation.php";
require_once "../classes/Bloodtable.php";
require_once '../classes/bloodBank.php';


use classes\hospitalrequestclass;
use classes\Validation;
use classes\Bloodtable;
use classes\bloodBank;


$bankid = $user->getBloodBankId();
$bloodBank = new bloodBank($bankid, null, null, null, null);
$bloodBank->GetBloodbankData($bankid);




if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["bloodGroup"],$_GET["HosReq"])) {
        $bloodgroup =Validation::decryptedValue($_GET["bloodGroup"]);
        $hosReqId = Validation::decryptedValue($_GET["HosReq"]);
       
     



?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
  <div class="mt-5 m-3 mb-1" style="color:gray;">
    <h5>Hospital Request Accept </h5>
  
  <div class="row bg-white m-3 pt-0  align-items-center justify-content-center rounded-5" style="height: 600px;">
  <div class="container">
  
    <div class="container bg-white m-0 p-0" style=" height: 500px; overflow: scroll;">
    <form action="../services/bbhrblpacketaccept.php" method="POST">
      <table class="table table-hover p-0">

        <!-- Table row -->


        <tr class="sticky-top ">

          <th class="p-2 mb-1 bg-dark text-white"></th>
          <th class="p-2 mb-1 bg-dark text-white" style="text-align: center;">ID</th>
          <th class="p-2 mb-1 bg-dark text-white" style="text-align: center;">Blood Group</th>
          <th class="p-2 mb-1 bg-dark text-white" style="text-align: center;">Quantity</th>
          <th class="p-2 mb-1 bg-dark text-white" style="text-align: center;">Expiry Date</th>





        </tr>
       

        <tbody>
          
       <?php
$bloodpackets= Bloodtable::getBloodpacketsbyBloodgp($bloodgroup,$bankid);

foreach ($bloodpackets as $packet) {
       ?>
          <tr>
            <th scope="row"> <input class="form-check-input mt-0" name="bloodId[]" type="checkbox" value="<?php echo $packet["bloodId"];?>" aria-label="Checkbox for following text input"></th>
            <td><?php echo $packet["bloodId"];?></td>
            <td><?php echo $packet["bloodGroup"];?></td>
            <td><?php echo $packet["quantity"];?></td>
            <td><?php echo $packet["expiryDate"];?></td>
          </tr>
          <?php
}
?>
          
        </tbody>
      </table>
      <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
      <input type="hidden" name="HosReqId" value="<?php echo $hosReqId; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
      <button class="btn btn-dark" type="submit" style="margin-left: 970px ">Save</button>
      </form>
      

     

    </div>
   
    </div>
  </div>
  
  </div>
  
  <?php
 }else{
echo "Cannot find bloodgroup!";
 }
}else{
  echo "Ivalid access!";
}
  ?>
</body>

</html>

