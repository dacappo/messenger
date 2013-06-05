<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 03.06.13
 * Time: 14:11
*/

include "messenger.php";
include "dbMessenger.php";

$contacts = $_POST['contacts'];
$user_id = $_POST['id'];

if (!isset($contacts)){
    echo "Not all required POST parameters are set";
}
// array structure: "number" => "name"
var_dump($contacts);
$arrayOfContacts = json_decode($contacts, true);

if (isset($arrayOfContacts)){
   $matchedContacts = compare_contacts($arrayOfContacts);
} else {
    echo "Server Error : during JSON decoding";
}

if (!empty($matchedContacts)){
    $newCreated = create_contacts($user_id, $matchedContacts);
} else {
    echo "Non of your contacts is using this messenger";
}

header('Content-Type: application/json');

if ($newCreated){
    echo createJSONResponseForNewContacts($matchedContacts, $user_id);
} else {
    echo "OK : No new contacts created";
}
