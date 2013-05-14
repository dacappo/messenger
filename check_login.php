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

    if(sizeOf($result) > 0) {
        return true;
    } else {
        return false;
    }



    /*
    $query = 'SELECT * FROM users WHERE ' . 'mobileNumber=\'' . $number . '\' AND password=\'' . $password . '\'';
    if ($result = $connection->query($query)) {


        $count = 0;
        while ($row = $result->fetch_row()) {
            $count++;
            if ($count < 2 && $row[1] == $number && $row[2] == $password){
                return true;
            } else {
                return false;
            }
        }

        $result->close();
    */
    }
    mysql_close($connection);
}
