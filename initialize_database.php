<?php
//$url = parse_url(getenv("mysql://bed9db9ba17777:5da87c13@us-cdbr-east-03.cleardb.com/heroku_fe4264edeb6329e?reconnect=true"));


$db = new mysqli('us-cdbr-east-03.cleardb.com', 'bed9db9ba17777', '5da87c13', 'heroku_fe4264edeb6329eb');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

// Create table
$sql="CREATE TABLE users(id int NOT NULL PRIMARY KEY, mobileNumber int, password CHAR(30))";


$sql = <<<SQL
    CREATE TABLE users(id int NOT NULL PRIMARY KEY, mobileNumber int, password CHAR(30))
SQL;

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}

?>