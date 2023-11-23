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
 * Description of hospital
 *
 * 
 */
class hospital {

    private $hospitalId;
    private $name;
    private $address;
    private $contactNumber;
    private $districtId;

    public function __construct($hospitalId, $name, $address, $contactNumber, $districtId) {
        $this->hospitalId = $hospitalId;
        $this->name = $name;
        $this->address = $address;
        $this->contactNumber = $contactNumber;
        $this->districtId = $districtId;
    }

    public function getHospitalId() {
        return $this->hospitalId;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getContactNumber() {
        return $this->contactNumber;
    }

    public function getDistrictId() {
        return $this->districtId;
    }

    public function setHospitalId($hospitalId): void {
        $this->hospitalId = $hospitalId;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setAddress($address): void {
        $this->address = $address;
    }

    public function setContactNumber($contactNumber): void {
        $this->contactNumber = $contactNumber;
    }

    public function setDistrictId($districtId): void {
        $this->districtId = $districtId;
    }

    public function AddHospital($email) {

        if (!is_numeric($this->districtId)) {
            // Handle the error, e.g., return false or throw an exception
            return false;
        }
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "INSERT INTO `hospital` ( `name`, `address`, `contactNumber`, `districtId`) VALUES ( ?, ?, ?, ?);";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->name);
            $pstmt->bindValue(2, $this->address);
            $pstmt->bindValue(3, $this->contactNumber);
            $pstmt->bindValue(4, $this->districtId);

            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                return self::addhospitaluser($con, $email, $this->name);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function addhospitaluser($con, $email, $name) {

        $hospitalId = $con->lastInsertId();
        $password = Validation::generateRandomPassword();

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


    if (User::AddUser($email, 3, $hashedPassword, null, null, $hospitalId)) {
        User::SendMail($password, $email, $name,"Hospital");
        return true;
    } else {
        return false;

    }

}


    


    public function GetHospitalData($hospitalId) {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT * FROM `hospital` WHERE `hospitalId` = ?";

            
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $hospitalId);

            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $rs = $pstmt->fetch(PDO::FETCH_OBJ);
                $this->name = $rs->name;
                $this->address = $rs->address;
                $this->contactNumber = $rs->contactNumber;
                $this->districtId = $rs->districtId;
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    
    public static function showAllHospital() {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT *, district.district, district.division FROM hospital, district WHERE hospital.districtId = district.districtId;`";

            $stmt = $con->prepare($query);

            $stmt->execute();

            $hospitalArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $hospitalArray[] = $row;
            }

            return $hospitalArray;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function editHospital() {
        if (!is_numeric($this->districtId)) {
            // Handle the error, e.g., return false or throw an exception
            return false;
        }
        
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
    
            $query = "UPDATE `hospital` SET `name`=?, `address`=?, `contactNumber`=?, `districtId`=? WHERE `hospitalId`=?";
    
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->name);
            $pstmt->bindValue(2, $this->address); 
            $pstmt->bindValue(3, $this->contactNumber);
            $pstmt->bindValue(4, $this->districtId);
            $pstmt->bindValue(5, $this->hospitalId); 

            $pstmt->execute();
    
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
   
   
    
       
    

}
