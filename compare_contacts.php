<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 03.06.13
 * Time: 14:11
*/

include "messenger.php";

$contacts = $_POST['contacts'];

if (!isset($contacts)){
    echo "Not all required POST parameters are set";
}

$arrayOfContacts = json_decode($contacts);

$resultDataJSON = compare_contacts($user_ID);

header('Content-Type: application/json');

echo $resultDataJSON;