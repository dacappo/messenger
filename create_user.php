<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 27.05.13
 * Time: 16:22
*/
include "dbconnection.php";
include "registration.php";

$mobileNumber = $_POST['mobileNumber'];
$password = $_POST['password'];

return create_user($mobileNumber, $password);

