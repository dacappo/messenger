<?php

include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$verCode = $_POST['verCode'];
$successful = false;

if (checkTempRegistrations($mobileNumber,$verCode,true)){
    $successful = true;
    create_user($mobileNumber, "messenger");
    echo "User successfully created!";
} else {
    echo "Wrong verification Code!";
}


