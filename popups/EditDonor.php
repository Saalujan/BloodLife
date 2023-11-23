<?php

require_once '../classes/Donor.php';
require_once '../classes/district.php';


use classes\district;


use classes\Donor;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["donorId"])) {
        $donorId = filter_var($_POST["donorId"], FILTER_SANITIZE_NUMBER_INT);
        $Donor = new Donor($donorId, null, null, null, null, null, null, null, null, null, null, null, null, null);
        if ($Donor->getDonorDetails()) {
            $districtId = $Donor->getDistrictId();
            $rs = district::getDistrictDivisionById($districtId);
            // Rest of your code


?>




            <div class="row align-items-center pb-3">
                <div class="col-3">
                    <h6>Name</h6>
                </div>
                <div class="col-9">
                    <input type="text" name="name" value="<?php echo $Donor->getName(); ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>

                </div>
            </div>


            <div class="row align-items-center pb-3">
                <div class="col-3">
                    <h6>Blood Group</h6>
                </div>
                <div class="col-9">
                    <select class="form-control form-control-lg" name="bloodGroup">
                        <option><?php echo $Donor->getBloodGroup(); ?></option>
                        <option value="A+">A+</option>
                        <option value="A-"> A-</option>
                        <option value="B+"> B+</option>
                        <option value="B-"> B-</option>
                        <option value="O+"> O+</option>
                        <option value="O-"> O-</option>
                        <option value="AB+"> AB+</option>
                        <option value="AB-"> AB-</option>

                    </select>
                </div>
            </div>







            <div class="row align-items-center pb-3">
                <div class="col-3">
                    <h6>Contact No</h6>
                </div>
                <div class="col-9">
                    <input type="text" name="contactNumber" value="<?php echo $Donor->getcontactNumber(); ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required id="contactNumberInput" oninput="validateMobileNumber(this.value)">
                    <p id="validationResult"></p>
                </div>
            </div>









            <div class="row align-items-center pb-3">
                <div class="col-3">
                    <h6>NIC</h6>
                </div>
                <div class="col-9">
                    <input type="text" name="nic" value="<?php echo $Donor->getNic(); ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                </div>
            </div>



            <div class="row align-items-center pb-3">
                <div class="col-3">
                    <h6>Medical Report</h6>
                </div>
                <div class="col-9">
                    <?php if ($Donor->getMedicalReport()) : ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($Donor->getMedicalReport()) ?>" style="width:30%">
                    <?php endif; ?>
                    <!-- Input for New Image -->
                    <input class="form-control" type="file" name="medicalReport" accept=".jpg, .png">
                    <p style="font-size: 9px; color: red;">Only jpg or png</p>
                </div>
             
            </div>








            <input type="hidden" name="donorId" value="<?php echo $Donor->getDonorId(); ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>



            <div class="row align-items-center pb-3">
                <div class="col-3">
                    <h6>Availability</h6>
                </div>
                <div class="col-6">
                    <select class="form-control form-control-sm" name="availability">
                        <option><?php echo $Donor->getAvailability(); ?></option>
                        <option value="Available">Available</option>
                        <option value="snoozed">snoozed</option>


                    </select>
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


<script src="../JS/DashboardJS.js"></script>