<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 29.05.13
 * Time: 13:59
 * To change this template use File | Settings | File Templates.
 */

function getContactsForUserID($user_id){

    $values = array();
    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query('SELECT origin_user_id,nickname FROM contacts WHERE ' . 'source_user_id="' . $user_id . '"')
    or die("SQL Error:" . mysql_error() . " with param" . var_dump($user_id) . " <br>");

    if (mysql_num_rows($result) > 0) {

        for ($i=0; $i<mysql_num_rows($result); ++$i)
            array_push($values, mysql_result($result,$i));
    }
    return $values;
    mysql_close($connection);
}

