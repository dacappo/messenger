<?php

include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$verCode = $_POST['verCode'];

if (checkTempRegistrations($mobileNumber,$verCode)){
    create_user($mobileNumber, "050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645");
    echo "User successfully created!";
} else {
    echo "Wrong verification code!";
}


