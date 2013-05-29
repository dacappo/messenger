<?php

include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];

if (checkDatabaseForUser($mobileNumber)){
    echo "User already exists";
} else {
    echo register($mobileNumber, generateValidationString(5));
}


