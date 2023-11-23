<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace classes;

require_once '../mail/Exception.php';
require_once '../mail/PHPMailer.php';
require_once '../mail/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'DbConnector.php';



use PDO;
use PDOException;
use classes\DbConnector;

class User
{

    private $userId;
    private $password;
    private $email;
    private $userRole;
    private $Token;
    private $expire;
    private $bloodBankId;
    private $donorId;
    private $hospitalId;

    public function __construct($userId, $password, $email, $userRole, $Token, $expire, $bloodBankId, $donorId, $hospitalId)
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->email = $email;
        $this->userRole = $userRole;
        $this->Token = $Token;
        $this->expire = $expire;
        $this->bloodBankId = $bloodBankId;
        $this->donorId = $donorId;
        $this->hospitalId = $hospitalId;
    }

    public function getToken()
    {
        return $this->Token;
    }

    public function getExpire()
    {
        return $this->expire;
    }

    public function setToken($Token): void
    {
        $this->Token = $Token;
    }

    public function setExpire($expire): void
    {
        $this->expire = $expire;
    }

    public function getUserId()
    {
        return $this->userId;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUserRole()
    {
        return $this->userRole;
    }

    public function getBloodBankId()
    {
        return $this->bloodBankId;
    }

    public function getDonorId()
    {
        return $this->donorId;
    }

    public function getHospitalId()
    {
        return $this->hospitalId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }



    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setUserRole($userRole): void
    {
        $this->userRole = $userRole;
    }

    public function setBloodBankId($bloodBankId): void
    {
        $this->bloodBankId = $bloodBankId;
    }

    public function setDonorId($donorId): void
    {
        $this->donorId = $donorId;
    }

    public function setHospitalId($hospitalId): void
    {
        $this->hospitalId = $hospitalId;
    }


    public static function AddUser($email, $userRole, $hashedPassword, $bloodBankId, $donorId, $hospitalId)
    {


        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();


            $query = "INSERT INTO `user` (`userId`, `password`, `email`, `userRole`, `bloodBankId`, `donorId`, `hospitalId`) VALUES (NULL, ?, ?, ?, ?, ?, ?);"; // Update the query to include all placeholders
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $hashedPassword);
            $pstmt->bindValue(2, $email);
            $pstmt->bindValue(3, $userRole);
            $pstmt->bindValue(4, $bloodBankId);
            $pstmt->bindValue(5, $donorId);
            $pstmt->bindValue(6, $hospitalId);


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


    function donorLogin()
    {
        $dbcon = new DbConnector;
        $conn = $dbcon->getConnection();
        $sql = "SELECT * FROM `user` WHERE email= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $this->email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);

            if (password_verify($this->password, $rs->password) && $rs->userRole == 5) {
                $this->Token = bin2hex(random_bytes(25));
                $this->expire = time() + (30 * 24 * 60 * 60);
                $this->userId = $rs->userId;
                return $this->updateToken();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function updateToken()
    {
        $dbcon = new DbConnector;
        $conn = $dbcon->getConnection();
        $sql = "UPDATE `user` SET `Token`=?,`expire`=? WHERE userId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $this->Token, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->expire, PDO::PARAM_STR);
        $stmt->bindParam(3, $this->userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    function validateToken()
    {
        $dbcon = new DbConnector;
        $conn = $dbcon->getConnection();
        $sql = "SELECT * FROM `user` WHERE Token= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $this->Token, PDO::PARAM_STR);
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_OBJ);
        if ($rs && $rs->expire > time()) {
            $this->donorId = $rs->donorId;
            $this->bloodBankId = $rs->bloodBankId;
            $this->userRole = $rs->userRole;
            $this->hospitalId = $rs->hospitalId;
            $this->expire = $rs->expire;
            $this->email  = $rs->email ;
            return true;
        } else {
            return false;
        }
    }


    public static function SendVerificationCode($code, $email)
    {

      
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'sachinformationsystem@gmail.com';                     //SMTP username
        $mail->Password = 'upyjmbtlcfckzoke';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //Recipients
        $mail->setFrom('sachinformationsystem@gmail.com');
        $mail->addAddress($email);     //Add a recipient             //Name is optional
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Verification Code';
        $message = "Your Verification Code :" . $code . "<br>";
        $message .= "Regards,<br>";
        $message .= "BloodLife";

        $mail->Body = $message;

        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
           
        }
    }

    public static function SendMail($password, $email, $name, $type)
    {
  
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'sachinformationsystem@gmail.com';                     //SMTP username
        $mail->Password = 'upyjmbtlcfckzoke';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //Recipients
        $mail->setFrom('sachinformationsystem@gmail.com');
        $mail->addAddress($email);     //Add a recipient             //Name is optional
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $type . ' Registration';
        $message = "Dear " . $name . ",<br>";
        $message .= "Welcome to BloodLife! , " . "<br>";
        $message .= "your account has been successfully created." . "<br><br>";
        $message .= "        Your username:     " . $email . "<br>";
        $message .= "        Your Password:     " . $password . "<br><br><br>";
        $message .= "Regards,<br>";
        $message .= "BloodLife";


        $mail->Body = $message;

        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function webLogin()
    {
        $dbcon = new DbConnector;
        $conn = $dbcon->getConnection();
        $sql = "SELECT * FROM `user` WHERE email= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $this->email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);

            if (password_verify($this->password, $rs->password)) {
                $this->Token = bin2hex(random_bytes(25));
                $this->expire = time() + (30 * 24 * 60 * 60);
                $this->userId = $rs->userId;
                $this->userRole = $rs->userRole;
                return $this->updateToken();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function verifyPassword($email, $password)
{
    try {
        $dbcon = new DbConnector;
        $conn = $dbcon->getConnection();

        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM `user` WHERE `email` = ?";
        $pstmt = $conn->prepare($query);
        $pstmt->bindValue(1, $email);

        // Execute the query
        $pstmt->execute();

        // Get the result
        $result = $pstmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Verify the password using password_verify
            if (password_verify($password, $result['password'])) {
                // Username and password match
                return true;
            }
        }

        // Username and password do not match
        return false;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error)
        // You may want to customize this part based on your error handling strategy
        error_log("Error: " . $e->getMessage());
        return false;
    } finally {
        // Close the connection in a finally block to ensure it always happens
        if ($conn) {
            $conn = null;
        }
    }
}


    public function changePassword($email, $newPassword)
    {
        $dbcon = new DbConnector;
        $conn = $dbcon->getConnection();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $query = "UPDATE `user` SET `password` =? WHERE `email` = ?";
        $pstmt = $conn->prepare($query);
        $pstmt->bindParam(1, $hashedPassword, PDO::PARAM_STR);
        $pstmt->bindParam(2, $email, PDO::PARAM_STR);
        if ($pstmt->execute()) {
            $conn = null; // Close the connection
            return true;
        } else {
            $conn = null; // Close the connection
        return false;
        }

        
    }
    public function getUserByEmail($email){
        try{
        $dbcon = new DbConnector;
        $conn = $dbcon->getConnection();

        $query = "SELECT FROM `user` WHERE `email`=`email`  ";
        $pstmt = $conn->prepare($query);
        $pstmt ->bindValue(1,$email,PDO::PARAM_STR);
        $pstmt->execute();

        if ($pstmt->rowCount() > 0) {
            $rs = $pstmt->fetch(PDO::FETCH_OBJ);
            $this->Token = $rs->Token;
            $this->expire = $rs->expire;
            $this->userId = $rs->userId;
            $this->userRole = $rs->userRole;
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    }
}
