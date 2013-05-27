<?php
$mobileNumber = $_POST['mobileNumber'];
//$imei = $_POST['imei'];

if (checkDatabaseForUser($mobileNumber)){
    echo "User already exists";
} else {
    echo register($mobileNumber, generateValidationString(5));
}


