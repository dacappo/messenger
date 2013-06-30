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
    echo("Temp_Users:     ");
    echo "ID: " . $row[0] . "  Number: " .  $row[1] . "  Verification Key: ". $row[2];
    echo "<br>";
}

$result = mysql_query('SELECT * FROM users;')
or die("There was an error running the query !<br>");

echo "<br>---------------------------------------------------------------------------<br>";


while($row = mysql_fetch_array($result))
{
    echo("Users:       ");
    echo "ID: " . $row[0] . "  Number: " .  $row[1] . "  password: ". $row[2];
    echo "<br>";
}

$result = mysql_query('SELECT * FROM contacts;')
or die("There was an error running the query !<br>");

echo "<br>---------------------------------------------------------------------------<br>";


while($row = mysql_fetch_array($result))
{
    echo("Contacts:       ");
    echo "ID: " . $row[0] . "  Source_ID: " .  $row[1] . "  Destination_ID: ". $row[2] . "  Nickname " . $row[3];
    echo "<br>";
}

$result = mysql_query('SELECT * FROM messages;')
or die("There was an error running the query !<br>");

echo "<br>---------------------------------------------------------------------------<br>";


while($row = mysql_fetch_array($result))
{
    echo("Messages:       ");
    echo "ID: " . $row[0] . "   Contact ID: " .  $row[1] . "   Content: ". $row[2] . "   Timestamp: " . $row[3] . "   READ Status: " . $row[4];
    echo "<br>";
}