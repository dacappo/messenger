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

    //################################# Vielleicht noch auslagerbar
    $connection = initializeConnectionToDB();
    $path = parse_url(getenv("CLEARDB_DATABASE_URL"), PHP_URL_PATH);
    $db = substr($path, 1);

    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");
    //#################################

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
function checkDatabaseForUser($pNumber, $pIMEI)
{
    $exist = false;
    if (isset($pNumber) && isset($pIMEI)) {
        $number = $pNumber;
        $imei = $pIMEI;
    } else {
        return false;
    }

    //################################# Vielleicht noch auslagerbar
    $connection = initializeConnectionToDB();
    $path = parse_url(getenv("CLEARDB_DATABASE_URL"), PHP_URL_PATH);
    $db = substr($path, 1);

    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");
    //#################################

    $result = mysql_query('SELECT * FROM users WHERE ' . 'mobileNumber="' . $number . '" AND imei="' . $imei . '"')
    or die("There was an error running the query !<br>");

    if (mysql_num_rows($result) <> 0) {
        $exist = true;
    }

    mysql_close($connection);
    return $exist;
}