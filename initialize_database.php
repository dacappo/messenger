<?php
$url=parse_url(getenv("mysql://bed9db9ba17777:5da87c13@us-cdbr-east-03.cleardb.com/heroku_fe4264edeb6329e?reconnect=true"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

mysql_connect($server, $username, $password);


mysql_select_db($db);

echo("success");

$sql = <<<SQL
    CREATE TABLE users(id int NOT NULL PRIMARY KEY, mobileNumber CHAR(66), password CHAR(66))
SQL;

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}
mysqli_close($con);

?>