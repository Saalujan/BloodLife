<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'DbConnector.php';
require_once 'User.php';
require_once 'Validation.php';

use classes\User;
use PDO;
use PDOException;
use classes\DbConnector;
use classes\Validation;

class Donor {

    private $donorId;
    private $name;
    private $bloodGroup;
    private $dob;
    private $contactNumber;
    private $nic;
    private $noOfDonation;
    private $coinValue;
    private $donationLastDate;
    private $availability;
    private $medicalReport;
    private $image;
    private $bloodBankId;
    private $districtId;

    public function __construct($donorId, $name, $bloodGroup, $dob, $contactNumber, $nic, $noOfDonation, $coinValue, $donationLastDate, $availability, $medicalReport, $image, $bloodBankId, $districtId) {
        $this->donorId = $donorId;
        $this->name = $name;
        $this->bloodGroup = $bloodGroup;
        $this->dob = $dob;
        $this->contactNumber = $contactNumber;
        $this->nic = $nic;
        $this->noOfDonation = $noOfDonation;
        $this->coinValue = $coinValue;
        $this->donationLastDate = $donationLastDate;
        $this->availability = $availability;
        $this->medicalReport = $medicalReport;
        $this->image = $image;
        $this->bloodBankId = $bloodBankId;
        $this->districtId = $districtId;
    }

    public function getDonorId() {
        return $this->donorId;
    }

    public function getName() {
        return $this->name;
    }

    public function getBloodGroup() {
        return $this->bloodGroup;
    }

    public function getDob() {
        return $this->dob;
    }

    public function getContactNumber() {
        return $this->contactNumber;
    }

    public function getNic() {
        return $this->nic;
    }

    public function getNoOfDonation() {
        return $this->noOfDonation;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image): void {
        $this->image = $image;
    }

    public function getCoinValue() {
        return $this->coinValue;
    }

    public function getDonationLastDate() {
        return $this->donationLastDate;
    }

    public function getAvailability() {
        return $this->availability;
    }

    public function getMedicalReport() {
        return $this->medicalReport;
    }

    public function getBloodBankId() {
        return $this->bloodBankId;
    }

    public function getDistrictId() {
        return $this->districtId;
    }

    public function setDonorId($donorId): void {
        $this->donorId = $donorId;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setBloodGroup($bloodGroup): void {
        $this->bloodGroup = $bloodGroup;
    }

    public function setDob($dob): void {
        $this->dob = $dob;
    }

    public function setContactNumber($contactNumber): void {
        $this->contactNumber = $contactNumber;
    }

    public function setNic($nic): void {
        $this->nic = $nic;
    }

    public function setNoOfDonation($noOfDonation): void {
        $this->noOfDonation = $noOfDonation;
    }

    public function setCoinValue($coinValue): void {
        $this->coinValue = $coinValue;
    }

    public function setDonationLastDate($donationLastDate): void {
        $this->donationLastDate = $donationLastDate;
    }

    public function setAvailability($availability): void {
        $this->availability = $availability;
    }

    public function setMedicalReport($medicalReport): void {
        $this->medicalReport = $medicalReport;
    }

    public function setBloodBankId($bloodBankId): void {
        $this->bloodBankId = $bloodBankId;
    }

    public function setDistrictId($districtId): void {
        $this->districtId = $districtId;
    }

    public function AddDonor($email, $password) {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "INSERT INTO `donor` (`donorId`, `name`, `bloodGroup`, `dob`, `contactNumber`, `nic`, `noOfDonation`, `coinValue`, `donationLastDate`, `availability`, `image`, `bloodBankId`, `districtId`) "
                    . "VALUES (NULL, ?, ?, ?, ?, ?, NULL, null, NULL, ?, NULL, ?, ?);";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->name, PDO::PARAM_STR);
            $pstmt->bindValue(2, $this->bloodGroup); // Use different placeholders for each parameter
            $pstmt->bindValue(3, $this->dob);
            $pstmt->bindValue(4, $this->contactNumber);
            $pstmt->bindValue(5, $this->nic);
            $pstmt->bindValue(6, $this->availability);
            $pstmt->bindValue(7, $this->bloodBankId);
            $pstmt->bindValue(8, $this->districtId);
            $pstmt->execute();
            if ($pstmt->rowCount() > 0) {
                return self::adduser($con, $email, $password);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function adduser($con, $email, $password) {

        $DonorId = $con->lastInsertId();

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if (User::AddUser($email, 5, $hashedPassword, null, $DonorId, null)) {
            return true;
        } else {
            return false;
        }
    }

    static function getAllDetails() {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT * FROM `donor`";

            $stmt = $con->prepare($query);
            $stmt->execute();

            $dataArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $dataArray[] = $row;
            }

            return $dataArray;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function getDonorById($donoId) {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT * FROM `donor` WHERE donorId=?";

            // Prepare the SQL statement
            $stmt = $con->prepare($query);

            // Bind the parameter (hospitalRequestID)
            $stmt->bindParam(1, $donoId, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the result as an associative array
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Handle the result as needed
            if ($result) {
                // Create a new hospitalrequestclass object using the retrieved data
                $newDonor = new Donor(
                        $donoId,
                        $result["name"],
                        $result["bloodGroup"],
                        $result["dob"],
                        $result["contactNumber"],
                        $result["nic"],
                        $result["noOfDonation"],
                        $result["coinValue"],
                        $result["donationLastDate"],
                        $result["availability"],
                        $result["medicalReport"],
                        $result["image"],
                        $result["bloodBankId"],
                        $result["districtId"]
                );

                return $newDonor;
            } else {
                // Return null or handle the case where no records are found
                return null;
            }
        } catch (PDOException $e) {
            // Handle the error or log it as needed
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public static function validateAttendance($donorId, $campaignId, $tableName) {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT * FROM `donationtable` WHERE donorId = ? && " . $tableName . " = ?";

            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $donorId, PDO::PARAM_INT);
            $stmt->bindParam(2, $campaignId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function validateDonationDonationDate() {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT donationLastDate FROM `donor` WHERE donorId= ?";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->donorId);

            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $rs = $pstmt->fetch(PDO::FETCH_OBJ);
                $this->donationLastDate = $rs->donationLastDate;

                $lastDonationDate = new \DateTime($this->donationLastDate);
                $today = new \DateTime();
                $lastDonationDate->add(new \DateInterval('P4M'));

                $isMoreThan4MonthsAgo = $lastDonationDate < $today;

                return $isMoreThan4MonthsAgo;
            } else {
                return false; // No records found for the donor
            }
        } catch (PDOException $e) {
            // Log or handle the error more explicitly than just echoing
            error_log("Error: " . $e->getMessage());
            return false; // Return false indicating an error occurred
        }
    }



    static function getAllDonor($bloodBankId){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
    
            $query = "SELECT donor.*, district.district,bloodbank.ContactNo 
            FROM donor JOIN district ON donor.districtId = district.districtId 
            join bloodbank on donor.bloodBankId = bloodbank.bloodBankId 
            where donor.bloodBankId = ?";
    
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $bloodBankId, PDO::PARAM_INT);
            $stmt->execute();
    
            $dataArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $dataArray[] = $row;
            }
    
            return $dataArray;
        } catch (PDOException $e) {
            echo "Database Connection Error: " . $e->getMessage();
        }
        
    }
    
public function EditDonor() {
    try {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $query = "UPDATE `donor` SET `name`= ?, `bloodGroup`= ?, `dob`= ?, `contactNumber`= ?, `nic`= ?, "
                . "`noOfDonation`= ?, `coinValue`= ?, `donationLastDate`= ?, `availability`= ?, "
                . "`medicalReport`= ?, `image`= ?, `bloodBankId`= ?, `districtId`= ? WHERE donorId = ?";

        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->name, PDO::PARAM_STR);
        $pstmt->bindValue(2, $this->bloodGroup, PDO::PARAM_STR);
        $pstmt->bindValue(3, $this->dob, PDO::PARAM_STR); 
        $pstmt->bindValue(4, $this->contactNumber, PDO::PARAM_STR);
        $pstmt->bindValue(5, $this->nic, PDO::PARAM_STR);
        $pstmt->bindValue(6, $this->noOfDonation, PDO::PARAM_INT);
        $pstmt->bindValue(7, $this->coinValue, PDO::PARAM_INT);
        $pstmt->bindValue(8, $this->donationLastDate, PDO::PARAM_STR); 
        $pstmt->bindValue(9, $this->availability, PDO::PARAM_STR);
        $pstmt->bindValue(10, $this->medicalReport, PDO::PARAM_LOB); 
        $pstmt->bindValue(11, $this->image, PDO::PARAM_LOB); 
        $pstmt->bindValue(12, $this->bloodBankId, PDO::PARAM_INT);
        $pstmt->bindValue(13, $this->districtId, PDO::PARAM_INT);
        $pstmt->bindValue(14, $this->donorId, PDO::PARAM_INT);

        $pstmt->execute();

        if ($pstmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

public function getDonorDetails() {
    try {
        $dbcon = new DbConnector(); // Replace with your database connection code
        $con = $dbcon->getConnection();

        // Prepare a SQL query to select campaign details by campaignId
        $query = "SELECT * FROM `donor` WHERE donorId=?";

        $pstmt = $con->prepare($query);
     //$pstmt->bindValue(':campaignId', PDO::PARAM_INT);
        $pstmt->bindValue(1, $this->donorId, PDO::PARAM_INT);

        $pstmt->execute();
        if ($pstmt->rowCount() > 0) {
            $rs = $pstmt->fetch(PDO::FETCH_OBJ);
            $this->name = $rs->name;
            $this->bloodGroup = $rs->bloodGroup;
            $this->dob = $rs->dob;
            $this->contactNumber = $rs->contactNumber;
            $this->nic = $rs->nic;
            $this->noOfDonation= $rs->noOfDonation;
            $this->coinValue = $rs->coinValue;
            $this->donationLastDate = $rs->donationLastDate;
            $this->availability = $rs->availability;
            $this->medicalReport = $rs->medicalReport;
            $this->image = $rs->image;
            $this->bloodBankId = $rs->bloodBankId;
            $this->districtId = $rs->districtId;
            
            return true;
        } else {
            return false;
        }

       // $campaignDetails = $pstmt->fetch(PDO::FETCH_ASSOC);

       // return $campaignDetails;
    } catch (PDOException $e) {
        // Handle database connection or query errors here
        error_log("Error: " . $e->getMessage());
       // return false;
    }
}



}
