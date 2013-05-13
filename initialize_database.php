<?php
//$url = parse_url(getenv("mysql://bed9db9ba17777:5da87c13@us-cdbr-east-03.cleardb.com/heroku_fe4264edeb6329e?reconnect=true"));
//$server = $url["host"];
//$username = $url["user"];
//$password = $url["pass"];
//$db = substr($url["path"],1);

$con = mysql_connect("us-cdbr-east-03.cleardb.com", "bed9db9ba17777", "5da87c13", "heroku_fe4264edeb6329eb");
// Check connection
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Create table
$sql="CREATE TABLE users(id int NOT NULL PRIMARY KEY, mobileNumber int, password CHAR(30))";

// Execute query
if (mysqli_query($con,$sql)){
    echo "Table users created successfully";
}else{
    echo "Error creating table: " . mysqli_error($con);
}

?>