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
                    "data": {
                        "elements": []
                    }
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
                    "data": {
                        "elements": []
                    }
                 }
                }';
    }
}

function buildJSONForArray($contacts)
{
    $JSONString = '{
                    "contacts": {
                        "message": "OK : Data for user",
                        "data": {
                            "elements": [';

    $isFirst = true;
    while (empty($contacts) == false) {
        if ($isFirst) {
            $singleArray = array_pop($contacts);
            $JSONString .= '"' . $singleArray[0] . '" : ';
            $JSONString .= '"' . $singleArray[1] . '"';
            $isFirst = false;
        } else {
            $singleArray = array_pop($contacts);
            $JSONString .= ', "' . $singleArray[0] . '" : ';
            $JSONString .= '"' . $singleArray[1] . '"';
        }
    }

    // close JSON
    $JSONString .= ']}}}';
    return $JSONString;
}

function compare_contacts($arrayOfContacts)
{
    $matchedContacts = array();

    foreach ($arrayOfContacts as $key => $val) {
        if (checkDatabaseForUser($key)) {
            $matchedContacts[] = $val;
        }
    }

    return $matchedContacts;

}

function create_contacts($pID, $pContacts)
{
    $infoContacts = array();

    if (isset($pID) && isset($verCode)) {
        $origin_id = $pID;
        $source_contacts = $pContacts;
    } else {
        return $infoContacts;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $sourceInformation = array();

    foreach ($source_contacts as $key => $value) {
        $SourceIDResult = mysql_query('SELECT id FROM users WHERE mobileNumber ="' . $key . '";')
        or die("There was an error running the query to look for existing users!<br>");
        if (mysql_num_rows($SourceIDResult) <> 0) {
            $sourceID = mysql_result($SourceIDResult, 0, 0);

            // SourceID => SourceName
            $sourceInformation[$sourceID] = $value;
        }
    }

    if (isset($sourceInformation)){
        foreach ($sourceInformation as $key => $value){
            mysql_query('INSERT INTO contacts (origin_user_id,destination_user_id,nickname) VALUES ("' . $origin_id . '","' . $key . '","' . $value . '")')
            or die("There was an error running the query to create contacts!<br>");
        }
    }

    mysql_close($connection);
    return $infoContacts;

}