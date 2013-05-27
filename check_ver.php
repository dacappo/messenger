<?php

include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$verCode = $_POST['verCode'];
$successful = false;

if (checkTempRegistrations($mobileNumber,$verCode)){
    $successful = true;
    create_user($mobileNumber, "messenger");
}

echo $successful;


