<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 24.05.13
 * Time: 10:24
 * To change this template use File | Settings | File Templates.
 */
//Komisch???
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
    $userID = 0;
    if (isset($pNumber)) {
        $number = $pNumber;
    } else {
        return $userID;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query('SELECT id FROM users WHERE ' . 'mobileNumber="' . $number . '"')
    or die("There was an error running the query in checkDataBaseForUser!<br>");

    if (mysql_num_rows($result) <> 0) {
        $userID = mysql_result($result, 0, 0);
    }

    mysql_close($connection);
    return $userID;
}

function checkTempRegistrations($pNumber, $pVerCode)
{
    $valid = false;
    if (isset($pNumber) && isset($pVerCode)) {
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

    $result = mysql_query('SELECT * FROM temp_registrations WHERE ' . 'mobileNumber="' . $number . ' " AND verCode="' . $code . '"')
    or die("There was an error running the query in checkTempRegistrations!<br>");

    if (mysql_num_rows($result) <> 0) {
        $valid = true;
    }

    mysql_close($connection);
    return $valid;
}

function insertTempRegistration($pNumber, $verCode)
{

    $successful = false;
    if (isset($pNumber) && isset($verCode)) {
        $number = $pNumber;
        $code = $verCode;
    } else {
        return $successful;
    }

    //Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    $result = mysql_query('SELECT mobileNumber FROM temp_registrations WHERE mobileNumber ="' . $number . '";')
    or die("There was an error running the query to look for existing temp registration!<br>");
    if (mysql_num_rows($result) <> 0) {
        die("User with number " . $number . " already exist");
    }

    $result = mysql_query('INSERT INTO temp_registrations (mobileNumber,verCode) VALUES ("' . $number . '","' . $code . '")')
    or die("There was an error running the query in insertTempRegistration()!<br>");

    $successful = checkTempRegistrations($number, $code, false);

    mysql_close($connection);
    return $successful;
}

function create_user($pNumber, $pPassword)
{
    $response = "";
    if (isset($pNumber) && isset($pPassword)) {
        $number = $pNumber;
        $ClientPassword = $pPassword;
    } else {
        return $response;
    }

    // Connect to DB
    $connection = initializeConnectionToDB();
    $db = selectDB();
    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");

    // Check if user already exists
    $result = mysql_query('SELECT mobileNumber FROM users WHERE mobileNumber ="' . $number . '";')
    or die("There was an error running the query to look for existing temp registration!<br>");
    if (mysql_num_rows($result) <> 0) {
        die("User with number: " . $number . " already exist");
    }

    // Create User
    $result = mysql_query("INSERT INTO users (mobileNumber,password) VALUES ('" . $number . "','" . $ClientPassword . "')")
    or die("There was an error running the query in create_user()!<br>");

    //Get user id of newly created user
    if (mysql_affected_rows() <> 0) {
        $result = mysql_query('SELECT id FROM users WHERE mobileNumber ="' . $number . '";');
        if (mysql_num_rows($result) <> 0) {
            $userID = mysql_result($result, 0, 0);
            $response = "OK : " . $userID;
        }
    } else {
        die("Internal Server Error during creating user");
    }

    mysql_close($connection);
    return $response;
}