<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 24.05.13
 * Time: 10:24
 * To change this template use File | Settings | File Templates.
 */

/*
* This function checks if the number and password match with the data n the server
*/
function checkDatabaseForUser($pNumber, $pPassword) {
    $successful = false;

    if (isset($pNumber) && isset($pPassword)) {
        $number = $pNumber;
        $ClientPassword = $pPassword;
    } else {
        return false;
    }

    /*
    * Initialize connection with HEROKU
    */
    $url=parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"],1);

    $connection = mysql_connect($server, $username, $password);
    if (!$connection) {
        die('Connection ERROR: ' . mysql_error());
    } /* else {
        echo("Connection to database established!<br>");
    } */

    $selected = mysql_select_db($db,$connection)
    or die("Could not select examples");
    //echo("Database selected!<br>");

    /*
    * Check Server data
    */
    // SQL query

    $result = mysql_query('SELECT * FROM users WHERE ' . 'mobileNumber="' . $number . '" AND password="' . $ClientPassword . '"');
    //or die("There was an error running the query !<br>");
    //echo("Query processed!<br>");

    if(mysql_num_rows($result) > 0) {
        $successful = true;
    }

    mysql_close($connection);

    return $successful;
}
