<?php
$url=parse_url(getenv("mysql://bed9db9ba17777:5da87c13@us-cdbr-east-03.cleardb.com/heroku_fe4264edeb6329e?reconnect=true"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

mysql_connect($server, $username, $password);
mysql_select_db($db);

$sql = <<<SQL
    CREATE TABLE users(id int NOT NULL PRIMARY KEY, mobileNumber CHAR(64), password CHAR(64))
SQL;
/*
$sql2 = <<<SQL
    INSERT INTO users(mobileNumber, password) VALUES ('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882', '050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')
SQL;
*/
if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
} else {
    echo("Table users succesfully created! <br>");
}
/*
if(!$result = $db->query($sql2)){
    die('There was an error running the query [' . $db->error . ']');
} else {
    echo("Example user 0123456789 with password messenger created! <br>");
}

*/
mysqli_close($con);

?>