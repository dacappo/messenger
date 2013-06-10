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

if (!isset($contacts) && !isset($user_id)){
    echo "Not all required POST parameters are set";
}

if (strlen($contacts) < 4){
    echo "Invalid JSON : Too short!";
}

$arrayOfContacts = json_decode($contacts, true);

if (isset($arrayOfContacts)){
   $matchedContacts = compare_contacts($arrayOfContacts, $user_id);
} else {
    echo "Server Error : during JSON decoding" . json_last_error() . var_dump($arrayOfContacts) . var_dump($contacts);
}

if (!empty($matchedContacts)){
    $newCreated = create_contacts($user_id, $matchedContacts);
    $contactsExisting = checkforExistingContacts($matchedContacts);
} else {
    echo "Non of your contacts is using this messenger";
}

header('Content-Type: application/json');

if ($newCreated || $contactsExisting){
    echo createJSONResponseForNewContacts($matchedContacts, $user_id);
} else {
    echo "OK : No new contacts created" . var_dump($matchedContacts) . var_dump($newCreated).var_dump($allExisting);
}
