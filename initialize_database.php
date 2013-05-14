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

$result = mysql_query("INSERT INTO users (mobileNumber,password) VALUES ('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882','050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')")
    or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

$result = mysql_query("SELECT id FROM users WHERE mobileNumber='84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882' AND password='050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645'")
    or die("There was an error running the query !<br>");

while($row = mysqli_fetch_array($result))
{
    echo("ID matched: ");
    echo $row['id'];
    echo "<br>";
}




mysql_close($connection);
echo("Connection closed!");

?>