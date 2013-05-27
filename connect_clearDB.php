<?php
$url=parse_url(getenv("mysql://bed9db9ba17777:5da87c13@us-cdbr-east-03.cleardb.com/heroku_fe4264edeb6329e?reconnect=true"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

mysql_connect($server, $username, $password);

mysql_select_db($db);

$result = mysql_query('SELECT * FROM temp_registrations')
or die("There was an error running the query !<br>");

while($row = mysql_fetch_array($result))
{
    echo("ID matched: ");
    echo $row[0];
    echo "<br>";
}



