<?php

require_once '../classes/User.php';
require_once '../classes/Validation.php';

use classes\User;
use classes\Validation;

session_start();
$status = null;


    if (isset($_COOKIE["remember_me"])) {
        $token = $_COOKIE["remember_me"];
        $user = new User(null, null, null, null, $token, null, null, null, null);
        if ($user->validateToken()) {
            $_SESSION["Token"] = $userArray['Token'];
            switch ($userArray['UserRole']) {
                case 1:

                    header('Location: ../Dashboards/AdminDashboard.php');
                    break;
                case 2:
                    header('Location: ../Dashboards/BloodBankDashboard.php');
                    break;
                case 3:
                    header('Location: ../Dashboards/HospitalDashboard.php');
                    break;
                default:
                    $status = 10;
            }
        } else {
            setcookie("remember_me", "", time() - (30 * 24 * 60 * 60 ));
            header('Location: ../index.php');
        
        }
    } else if (isset($_POST["email"], $_POST["password"])) {

        if (!empty($_POST["email"] && $_POST["password"])) {

            // sanitizing the inputs
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            $validateEmail = Validation::validateGmail($email);
            if ($validateEmail) {
                $user = new User(null, $password, $email, null, null, null, null, null, null);
                if ($user->webLogin() != false) {
                    $userArray = $user->webLogin();
                    $_SESSION["Token"] = $userArray['Token'];


                    if (isset($_POST["remember"])) {
                        setcookie("remember_me", $_SESSION["Token"], $user->getExpire());
                        switch ($userArray['UserRole']) {
                            case 1:
    
                                header('Location: ../Dashboards/AdminDashboard.php');
                                break;
                            case 2:
                                header('Location: ../Dashboards/BloodBankDashboard.php');
                                break;
                            case 3:
                                header('Location: ../Dashboards/HospitalDashboard.php');
                                break;
                            default:
                                $status = 10;
                        }
                    } else {
                        switch ($userArray['UserRole']) {
                            case 1:
    
                                header('Location: ../Dashboards/AdminDashboard.php');
                                break;
                            case 2:
                                header('Location: ../Dashboards/BloodBankDashboard.php');
                                break;
                            case 3:
                                header('Location: ../Dashboards/HospitalDashboard.php');
                                break;
                            default:
                                $status = 10;
                        }
                    }
                } else {
                    $status = 6;
                }
            } else {
                $status = 5;
            }
        } else {
            //status for empty value
            $status = 03;
        }
    } else {
        //status for isset value
        $status = 02;
    }

echo $status;
