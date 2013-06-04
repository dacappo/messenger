<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 29.05.13
 * Time: 13:59
 * To change this template use File | Settings | File Templates.
 */
include "dbconnection.php";

function getContactsForUserID($user_id)
{

    $values = array();
    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query('SELECT destination_user_id,nickname FROM contacts WHERE ' . 'origin_user_id="' . $user_id . '"')
    or die("SQL Error:" . mysql_error() . " with param" . var_dump($user_id) . " <br>");

    if (mysql_num_rows($result) > 0) {
        for ($i = 0; $i < mysql_num_rows($result); ++$i) {
            $contact_id = mysql_result($result, $i, 0);
            $contact_nickname = mysql_result($result, $i, 1);
            $data = array($contact_id, $contact_nickname);
            array_push($values, $data);
        }
    }
    mysql_close($connection);
    return $values;
}

function create_contacts($pID, $pContacts)
{
    $infoContacts = false;

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
            $infoContacts = mysql_query('INSERT INTO contacts (origin_user_id,destination_user_id,nickname) VALUES ("' . $origin_id . '","' . $key . '","' . $value . '")')
            or die("There was an error running the query to create contacts!<br>");

        }
    }

    mysql_close($connection);
    return $infoContacts;

}

