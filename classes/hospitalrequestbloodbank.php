<?php

namespace classes;

/**
 * Description of Donation
 *
 * @author aasad
 */
require_once 'DbConnector.php';
require_once 'Validation.php';

use PDO;
use PDOException;
use classes\DbConnector;
use classes\Validation;

class Hospitalrequestbloodbank
{
    private $HRBId;
    private $hospitalRequestId;
    private $bloodBankId;
    private $bloodId;

    public function __construct($HRBId, $hospitalRequestId, $bloodBankId, $bloodId)
    {
        $this->HRBId = $HRBId;
        $this->hospitalRequestId = $hospitalRequestId;
        $this->bloodBankId = $bloodBankId;
        $this->bloodId = $bloodId;
    }

    public function getHRBId()
    {
        return $this->HRBId;
    }

    public function getHospitalRequestId()
    {
        return $this->hospitalRequestId;
    }

    public function getBloodBankId()
    {
        return $this->bloodBankId;
    }

    public function getBloodId()
    {
        return $this->bloodId;
    }

    public function setHRBId($HRBId): void
    {
        $this->HRBId = $HRBId;
    }

    public function setHospitalRequestId($hospitalRequestId): void
    {
        $this->hospitalRequestId = $hospitalRequestId;
    }

    public function setBloodBankId($bloodBankId): void
    {
        $this->bloodBankId = $bloodBankId;
    }

    public function setBloodId($bloodId): void
    {
        $this->bloodId = $bloodId;
    }

    public function AddHospitalReqAccept()
    {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "INSERT INTO `hospitalrequestbloodbank`(`HRBId`, `hospitalRequestId`, `bloodBankId`, `bloodId`) VALUES (?,?,?,?)";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->HRBId); // Use different placeholders for each parameter
            $pstmt->bindValue(2, $this->hospitalRequestId);
            $pstmt->bindValue(3, $this->bloodBankId);
            $pstmt->bindValue(4, $this->bloodId);
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function GetCountOfAcceptBloodBnk()
    {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT COUNT(*) AS rowCount FROM `hospitalrequestbloodbank` WHERE hospitalRequestId = ?";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->hospitalRequestId, PDO::PARAM_INT);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            return $row["rowCount"];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function GetCountOfAcceptBloodQuantity()
    {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT hospitalrequestbloodbank.*, bloodtable.quantity
            FROM hospitalrequestbloodbank
            INNER JOIN bloodtable ON hospitalrequestbloodbank.bloodId = bloodtable.bloodId
            WHERE hospitalrequestbloodbank.hospitalRequestId = ?";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->hospitalRequestId, PDO::PARAM_INT);
            $pstmt->execute();
            $quantity = null;
            while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
                $quantity = $row["quantity"] + $quantity;
            }

            return $quantity;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function GetAcceptedBloodBankDetail()
    {
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $query = "SELECT DISTINCT hospitalrequestbloodbank.*, bloodbank.*
            FROM hospitalrequestbloodbank
            INNER JOIN bloodbank ON hospitalrequestbloodbank.bloodBankId = bloodbank.bloodBankId
            WHERE hospitalrequestbloodbank.hospitalRequestId = ? GROUP BY bloodbank.bloodBankId";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->hospitalRequestId, PDO::PARAM_INT);
            $pstmt->execute();

            $dataArray = array();
            while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
                $dataArray[] = $row;
            }

            return $dataArray;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
