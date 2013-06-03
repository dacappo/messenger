<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 03.06.13
 * Time: 14:11
*/

include "messenger.php";

$contacts = $_POST['contacts'];
$user_id = $_POST['id'];

if (!isset($contacts)){
    echo "Not all required POST parameters are set";
}
// array structure: "number" => "name"
$arrayOfContacts = json_decode($contacts);

if (isset($arrayOfContacts)){#
   $matchedContacts = compare_contacts($arrayOfContacts);
} else {
    echo "Server Error : during JSON decoding";
}

if (!empty($matchedContacts)){
    create_contacts($user_id, $matchedContacts);
} else {
    echo "Non of your contacts is using this messenger" .var_dump($arrayOfContacts) . var_dump($matchedContacts);
}

header('Content-Type: application/json');

echo $resultDataJSON;