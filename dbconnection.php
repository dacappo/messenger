<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 24.05.13
 * Time: 10:24
 * To change this template use File | Settings | File Templates.
 */

/*
 * Initialize connection with HEROKU
 */
function initializeConnectionToDB()
{
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];

    $connection = mysql_connect($server, $username, $password);
    if (!$connection) {
        die('Connection ERROR: ' . mysql_error());
    } else {
        return $connection;
    }
}

/*
 * Select Heroku Database
 */
function selectDB()
{
    $path = parse_url(getenv("CLEARDB_DATABASE_URL"), PHP_URL_PATH);
    $db = substr($path, 1);
    return $db;
}

/*
* This function checks if the number and password match with the data on the server
*/
function checkLoginForUser($pNumber, $pPassword)
{
    $successful = false;
    if (isset($pNumber) && isset($pPassword)) {
        $number = $pNumber;
        $ClientPassword = $pPassword;
    } else {
        return false;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query('SELECT * FROM users WHERE ' . 'mobileNumber="' . $number . '" AND password="' . $ClientPassword . '"')
    or die("There was an error running the query !<br>");

    if (mysql_num_rows($result) > 0) {
        $successful = true;
    }

    mysql_close($connection);
    return $successful;
}

/*
* This function checks if the number and IMEI are already existing
*/
function checkDatabaseForUser($pNumber)
{
    $exist = false;
    if (isset($pNumber)) {
        $number = $pNumber;
    } else {
        return $exist;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query('SELECT * FROM users WHERE ' . 'mobileNumber="' . $number . '"')
    or die("There was an error running the query !<br>");

    if (mysql_num_rows($result) <> 0) {
        $exist = true;
    }

    mysql_close($connection);
    return $exist;
}

function checkTempRegistrations($pNumber, $pVerCode)
{
    $valid = false;
    if (isset($pNumber) && isset($verCode)) {
        $number = $pNumber;
        $code = $pVerCode;
    } else {
        return $valid;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query('SELECT * FROM temp_registrations WHERE ' . 'mobileNumber="' . $number . ' "AND verCode="' . $code . '"')
    or die("There was an error running the query !<br>");

    if (mysql_num_rows($result) <> 0) {
        $valid = true;
    }

    mysql_close($connection);
    return $valid;
}

function insertTempRegistration($mobileNumber,$generatedKey){
    $successful = true;
    if (isset($pNumber) && isset($verCode)) {
        $number = $mobileNumber;
        $code = $generatedKey;
    } else {
        return $successful;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query("INSERT INTO temp_registrations (mobileNumber,verCode) VALUES ('". $number . "','" . $code . "')")
    or die("There was an error running the query !<br>");

    $successful = true;

    mysql_close($connection);
    return $successful;
}