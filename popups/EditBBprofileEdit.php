<
        <?php          
                    require_once '../classes/bloodBank.php';
                    require_once '../classes/district.php';
                    
                    
                    use classes\district;
                    
                  
                    use classes\bloodBank;
                

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (!empty($_POST["bloodBankId"])) {
                            $bloodBankId = filter_var($_POST["bloodBankId"], FILTER_SANITIZE_NUMBER_INT);
                            $bloodBank = new bloodBank($bloodBankId, null, null, null, null);
                            if ($bloodBank->GetBloodbankData($bloodBankId)) {
                                $districtId = $bloodBank->getDistrictId();
                                $rs = district::getDistrictDivisionById($districtId);
                                // Rest of your code
                            

                    ?>
                  
          

        

        <?php

} else {
}
} else {
}
} else {
}

?>


<script src="../JS/DashboardJS.js"></script>