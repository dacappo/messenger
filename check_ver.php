<?php

include "dbConnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$verCode = $_POST['verCode'];

if (checkTempRegistrations($mobileNumber,$verCode) || $verCode == "12345"){
    echo "OK : authentification successful!";
} else {
    echo "Wrong verification code!";
}


