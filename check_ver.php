<?php

include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$verCode = $_POST['verCode'];

if (checkTempRegistrations($mobileNumber,$verCode)){
    create_user($mobileNumber, "messenger");
    echo "User successfully created!";
} else {
    echo "Wrong verification code!";
}


