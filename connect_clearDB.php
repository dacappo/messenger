<?php
include "dbconnection.php";

$connection = initializeConnectionToDB();
$db = selectDB();
$selected = mysql_select_db($db, $connection)
or die("Could not select Database");

$result = mysql_query('SELECT * FROM temp_registrations;')
or die("There was an error running the query !<br>");

while($row = mysql_fetch_array($result))
{
    echo("ID matched: ");
    echo "ID: " . $row[0] . "  Number: " .  $row[1] . "  Verification Key: ". $row[2];
    echo "<br>";
}



