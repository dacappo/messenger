<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 27.05.13
 * Time: 16:22
*/
include "dbConnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$password = $_POST['password'];

if (create_user($mobileNumber, $password)){
    echo "OK : User created";
} else {
    echo "Server Error during Runtime with following parameters:" . var_dump($mobileNumber,$mobileNumber);
}
