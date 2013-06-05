<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 29.05.13
 * Time: 13:51
 */

include "dbMessenger.php";
include "dbconnection.php";

function show_contacts($pUser_id)
{

    if (isset($pUser_id)) {
        $user_id = $pUser_id;
    } else {
        return '{
                 "contacts": {
                    "message": "ERROR : No valid user",
                    "data": []
                 }
                }';
    }

    $aContacts = getContactsForUserID($user_id);

    if (count($aContacts) > 0) {
        return buildJSONForArray($aContacts);
    } else {
        return '{
                 "contacts": {
                    "message": "No contacts for user with id: ' . var_dump($pUser_id) . '",
                    "data": []
                 }
                }';
    }
}

function buildJSONForArray($contacts)
{
    $JSONString = '{
                    "contacts": {
                        "message": "OK : Data for user",
                        "data": [';

    $isFirst = true;
    while (empty($contacts) == false) {
        if ($isFirst) {
            $singleArray = array_pop($contacts);
            $JSONString .= '{ "id" : "' . $singleArray[0] . '" ,';
            $JSONString .= ' "name" : "' . $singleArray[1] . '" } ';
            $isFirst = false;
        } else {
            $singleArray = array_pop($contacts);
            $JSONString .= ', { "id" : "' . $singleArray[0] . '" ,';
            $JSONString .= ' "name" : "' . $singleArray[1] . '" } ';
        }
    }

    // close JSON
    $JSONString .= ']}}';
    return $JSONString;
}

function compare_contacts($arrayOfContacts)
{
    $matchedContacts = array();

    foreach ($arrayOfContacts as $contact) {
        if ($contact['id'] = checkDatabaseForUser($contact['number'])) {
            $matchedContacts[] = $contact;
        }
    }

    return $matchedContacts;
}

function createJSONResponseForNewContacts($matchedContacts, $user_id){
    $JSONString = '[';

    $contactInfoArray = getContactIDsForNumbers($matchedContacts, $user_id );

    $isFirst = true;
    while (empty($contactInfoArray) == false) {
        if ($isFirst) {
            $singleObject = array_pop($contactInfoArray);
            var_dump($singleObject);
            $JSONString .= '{ "number" : "' . $singleObject[1] . '" ,';
            $JSONString .= ' "id" : "' . $singleObject[0] . '" } ';
            $isFirst = false;
        } else {
            $singleObject = array_pop($contactInfoArray);
            $JSONString .= ', { "id" : "' . $singleObject[1] . '" ,';
            $JSONString .= ' "name" : "' . $singleObject[0] . '" } ';
        }
    }

    // close JSON
    $JSONString .= ']';
    return $JSONString;
}