<?php
/* ##################
* Check User Login
*/ ##################

/*
* This function checks if the number and password match with the data n the server
*/
function check_database($pNumber, $pPassword) {
    $number = "";
    $password = "";

    if (isset($pNumber) && isset($pPassword)) {
        $number = $pNumber;
        $password = $pPassword;
    } else {
        echo "Number or Password is missing!";
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
    } else {
        echo("Connection to database established!<br>");
    }

    $selected = mysql_select_db($db,$connection)
        or die("Could not select examples");
    echo("Database selected!<br>");

    /*
    * Check Server data
    */
    // SQL query

    $result = mysql_query('SELECT * FROM users WHERE ' . 'mobileNumber="' . $number . '" AND password="' . $password . '"')
        or die("There was an error running the query !<br>");
    echo("Table dropped!<br>");

    if(mysql_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

    
    mysql_close($connection);
}
