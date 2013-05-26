<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 26.05.13
 * Time: 10:58
 * To change this template use File | Settings | File Templates.
 */

echo checkData('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882', '050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645');

function checkData($pNumber, $pIMEI)
{
    $exist = false;
    if (isset($pNumber) && isset($pIMEI)) {
        $number = $pNumber;
        $imea = $pIMEI;
    } else {
        return false;
    }

    //################################# Vielleicht noch auslagerbar
    $connection = initializeConnectionToDB();
    $path = parse_url(getenv("CLEARDB_DATABASE_URL"), "PHP_URL_PATH");
    $db = substr($path, 1);
    echo $db;
    echo $connection;

    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");
    //#################################

    $result = mysql_query('SELECT * FROM users WHERE ' . 'mobileNumber="' . $number . '" AND imea="' . $imea . '"')
    or die("There was an error running the query !<br>");

    if (mysql_num_rows($result) <> 0) {
        $exist = true;
    }

    mysql_close($connection);
    return $exist;
}