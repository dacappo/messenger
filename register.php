<?php

include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];

if ($user_id = checkDatabaseForUser($mobileNumber)){
    echo "User already exists : ". $user_id;
} else {
    echo register($mobileNumber, generateValidationString(5));
}


