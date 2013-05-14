<?php
// mysql://bed9db9ba17777:5da87c13@us-cdbr-east-03.cleardb.com/heroku_fe4264edeb6329e?reconnect=true
$url=parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

$connection = mysql_connect($server, $username, $password);

if (!$connection) {
    die('Verbindung schlug fehl: ' . mysql_error());
} else {
    echo("Connection to database established!<br>");
}

//mysql_select_db($db);

$selected = mysql_select_db($db,$connection)
    or die("Could not select examples");
echo("Database selected!<br>");

$result = mysql_query("DROP TABLE users")
    or die("There was an error running the query !<br>");
echo("Table dropped!<br>");

$result = mysql_query("CREATE TABLE users(id int NOT NULL PRIMARY KEY, mobileNumber CHAR(66), password CHAR(66))")
    or die("There was an error running the query !<br>");
echo("Table created!<br>");


mysql_close($connection);
echo("Connection closed!");

?>