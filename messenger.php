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

function compare_contacts($arrayOfContacts, $sourceID)
{
    $matchedContacts = array();

    foreach ($arrayOfContacts as $contact) {
        if ($DestinationID = checkDatabaseForUser($contact['number'])) {
            //Check if Contact pair alrady exist and if yes get ID
            $contact['id'] = $DestinationID;
            if ($existingContactID = checkDatabaseForContact($sourceID, $DestinationID)) {
                $contact['contactID'] = $existingContactID;
            }
            $matchedContacts[] = $contact;
        }
    }

    return $matchedContacts;
}

function createJSONResponseForNewContacts($matchedContacts, $user_id)
{
    $JSONString = '[';
    $contactInfoArray = getContactIDsForNumbers($matchedContacts, $user_id);

    $isFirst = true;
    while (empty($contactInfoArray) == false) {
        if ($isFirst) {
            $singleObject = array_pop($contactInfoArray);
            $JSONString .= '{ "number" : "' . $singleObject[0] . '" ,';
            $JSONString .= ' "id" : "' . $singleObject[1] . '" } ';
            $isFirst = false;
        } else {
            $singleObject = array_pop($contactInfoArray);
            $JSONString .= ', { "number" : "' . $singleObject[0] . '" ,';
            $JSONString .= ' "id" : "' . $singleObject[1] . '" } ';
        }
    }

    // close JSON
    $JSONString .= ']';
    return $JSONString;
}

//Insert existing contacts to new created
function checkForExistingContacts($matchedContacts)
{
    $exist = false;
    foreach ($matchedContacts as $contact) {
        if (isset($contact['contactID'])) {
            $exist = true;
        }
    }
    return $exist;
}

/*
 * param: $messageData[0] = contact_id, $messageData[1] = body, $messageData[2] = timestamp
 */
function sendMessage($messageData)
{
    $successful = false;
    //Parties unused
    $messageParties = getPartiesID($messageData[0]);
    if (isset($messageParties)) {
        $successful = insertMessageIntoDB($messageData);
    }
    return $successful;
}

//TODO Timestamp integration
function getMessages($contact_id)
{

    $parties = getPartiesID($contact_id);
    $opposite_contact_id = getContactsForBothUserIDs($parties);

    //Get messages for the contact owner and the messages from contact to owner
    $messages = getMessagesFromDB($contact_id, $opposite_contact_id);

    //Create JSON
    $messagesJSON = createJSONMessages($messages);
    return $messagesJSON;
}

function check_for_contacts($user_id)
{
    $contact_IDs = lookForNewMessages($user_id);

    if (!empty($contact_IDs)) {
        $contactIDsJSON = json_encode($contact_IDs);
    } else {
        $contactIDsJSON = '[]';
    }

   //extend JSON with root tag
    $contactIDsJSON .= '{ "contact_IDs" : ' . $contactIDsJSON . ' }';

    if (isset($contactIDsJSON)) {
        return $contactIDsJSON;
    } elseif (!empty($contact_IDs) && !isset($contactIDsJSON)) {
        die("Server Error during Parsing");
    } else {
        return "OK : no new messages";
    }

}

function createJSONMessages($messages)
{
    $JSONString = '[ ';
    $isFirst = true;
    while (empty($messages) == false) {
        if ($isFirst) {
            $singleObject = array_pop($messages);
            $JSONString .= '{ "id" : "' . $singleObject['contact_id'] . '" ,';
            $JSONString .= ' "content" : "' . $singleObject['content'] . '" ,';
            $JSONString .= ' "timestamp" : "' . $singleObject['date_time'] . '" } ';
            $isFirst = false;
        } else {
            $singleObject = array_pop($messages);
            $JSONString .= ', { "id" : "' . $singleObject['contact_id'] . '" ,';
            $JSONString .= ' "content" : "' . $singleObject['content'] . '" ,';
            $JSONString .= ' "timestamp" : "' . $singleObject['date_time'] . '" } ';
        }
    }

    // close JSON
    $JSONString .= ']';
    return $JSONString;
}