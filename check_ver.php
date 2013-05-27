<?php

include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$verCode = $_POST['verCode'];

if (checkTempRegistrations($mobileNumber,$verCode)){
    echo "OK : authentification successful!";
} else {
    echo "Wrong verification code!";
}


