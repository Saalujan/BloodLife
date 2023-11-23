<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace classes;

require_once 'DbConnector.php';
require_once 'User.php';

use classes\User;
use PDO;
use PDOException;
use classes\DbConnector;

/**
 * Description of bloodBank
 *
 *
 */
class bloodBank {

    private $bloodBankId;
    private $bloodBankName;
    private $Address;
    private $ContactNo;
    private $districtId;
    
    public function __construct($bloodBankId, $bloodBankName, $Address, $ContactNo, $districtId) {
        $this->bloodBankId = $bloodBankId;
        $this->bloodBankName = $bloodBankName;
        $this->Address = $Address;
        $this->ContactNo = $ContactNo;
        $this->districtId = $districtId;
    }
    
    public function getBloodBankId() {
        return $this->bloodBankId;
    }

    public function getBloodBankName() {
        return $this->bloodBankName;
    }

    public function getAddress() {
        return $this->Address;
    }

    public function getContactNo() {
        return $this->ContactNo;
    }

    public function getDistrictId() {
        return $this->districtId;
    }
    
    public function setBloodBankId($bloodBankId): void {
        $this->bloodBankId = $bloodBankId;
    }

    public function setBloodBankName($bloodBankName): void {
        $this->bloodBankName = $bloodBankName;
    }

    public function setAddress($Address): void {
        $this->Address = $Address;
    }

    public function setContactNo($ContactNo): void {
        $this->ContactNo = $ContactNo;
    }

    public function setDistrictId($districtId): void {
        $this->districtId = $districtId;
    }

    public function AddBloodBank($email) {
        
        if (!is_numeric($this->districtId)) {
            // Handle the error, e.g., return false or throw an exception
            return false;
        }
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
           
            $query = "INSERT INTO `bloodbank` ( `bloodBankName`, `Address`, `ContactNo`, `districtId`) VALUES ( ?, ?, ?, ?);";
    
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->bloodBankName);
            $pstmt->bindValue(2, $this->Address); 
            $pstmt->bindValue(3, $this->ContactNo);
            $pstmt->bindValue(4, $this->districtId);
            
    
            $pstmt->execute();
    
            if ($pstmt->rowCount() > 0) {
                return self::addbloodbankuser($con, $email, $this->bloodBankName);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function addbloodbankuser($con, $email, $bloodBankName) {

        $bloodBankId = $con->lastInsertId();
        $password = Validation::generateRandomPassword();

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


    if (User::AddUser($email, 2, $hashedPassword,  $bloodBankId,null, null)) {
        User::SendMail($password, $email, $bloodBankName,"bloodbank");
        return true;
    } else {
        return false;

    }

}


    public  function GetBloodbankData($bloodBankId) {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
    
            $query = "SELECT * FROM  `bloodbank` WHERE `bloodBankId` = ?";
    
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $bloodBankId);
    
            $pstmt->execute();
    
            if ($pstmt->rowCount() > 0) {
                $rs = $pstmt->fetch(PDO::FETCH_OBJ);
                 $this->bloodBankName = $rs->bloodBankName;
                 $this->Address = $rs->Address;
                 $this->ContactNo = $rs->ContactNo;
                 $this->districtId = $rs->districtId;
                 return true;

            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function showAllBloodbank() {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT *, district.district, district.division FROM bloodbank, district WHERE bloodbank.districtId = district.districtId;`";
            


            $stmt = $con->prepare($query);
            
            $stmt->execute();

            $bloodBankArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bloodBankArray[] = $row;
            }

            return $bloodBankArray;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
public function GetBloodbankByName() {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
    
            $query = "SELECT * FROM  `bloodbank` WHERE `bloodBankName` = ?";
    
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->bloodBankName, PDO::PARAM_INT);
    
            $pstmt->execute();
    
            if ($pstmt->rowCount() > 0) {
                $rs =  $pstmt->fetch(PDO::FETCH_OBJ);
                $this->bloodBankId = $rs->bloodBankId;
                $this->Address = $rs->Address;
                $this->	ContactNo = $rs->ContactNo;
                $this->districtId  = $rs->districtId;
                return true;
            } else {
                return false; // Return false if no data is found
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function editBloodbank() {
        if (!is_numeric($this->districtId)) {
            // Handle the error, e.g., return false or throw an exception
            return false;
        }
        
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
    
            $query = "UPDATE `bloodbank` SET `bloodBankName` = ?, `Address` = ?, `ContactNo` = ?, `districtId` = ? WHERE `bloodBankId` = ?";


            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->bloodBankName);
            $pstmt->bindValue(2, $this->Address); 
            $pstmt->bindValue(3, $this->ContactNo);
            $pstmt->bindValue(4, $this->districtId);
            $pstmt->bindValue(5, $this->bloodBankId); 

            $pstmt->execute();
    
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}
