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
        if (checkDatabaseForUser($contact['number'])) {
            $matchedContacts[] = $contact;
        }
    }

    return $matchedContacts;

}

function create_contacts($pID, $pContacts)
{
    $infoContacts = array();

    if (isset($pID) && isset($pContacts)) {
        $origin_id = $pID;
        $contacts = $pContacts;
    } else {
        return $infoContacts;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $destinationInformation = array();

    foreach ($contacts as $key => $value) {
        $destinationIDResult = mysql_query('SELECT id FROM users WHERE mobileNumber ="' . $value['number'] . '";')
        or die("There was an error running the query to look for existing users!<br>");
        if (mysql_num_rows($destinationIDResult) <> 0) {
            $destinationID = mysql_result($destinationIDResult, 0, 0);
            // SourceID => SourceName
            $destinationInformation[$destinationID] = $value['name'];

        }
    }

    if (isset($destinationInformation)) {

        foreach ($destinationInformation as $key => $value) {
            mysql_query('INSERT INTO contacts (origin_user_id,destination_user_id,nickname) VALUES ("' . $origin_id . '","' . $key . '","' . $value . '")')
            or die("There was an error running the query to create contacts!<br>");
        }
    }

    mysql_close($connection);
    return $infoContacts;

}