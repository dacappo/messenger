<?php
include "dbconnection.php";

//Connect to DB
$connection = initializeConnectionToDB();
$db = selectDB();
$selected = mysql_select_db($db, $connection)
or die("Could not select Database");


/*
 * Configuration of Database
 */
$result = mysql_query("SET @@auto_increment_increment=1;")
or die("There was an error during configuration !<br>");
// --
$result = mysql_query("SHOW VARIABLES LIKE 'foreign_key_checks';")
or die("There was an error during configuration !<br>");
$row = mysql_fetch_array($result);
echo print_r($row) . "<br>";
// --
$result = mysql_query("SHOW VARIABLES LIKE 'storage_engine';")
or die("There was an error during configuration !<br>");
$row = mysql_fetch_array($result);
echo print_r($row) . "<br>";


/*
 * Clear existing Tables
 * First Drop contacts because of foreign key relationship.
*/
$result = mysql_query("DROP TABLE messages")
or die("There was an error running the query !<br>");
echo("Table dropped!<br>");
$result = mysql_query("DROP TABLE contacts")
or die("There was an error running the query !<br>");
echo("Table dropped!<br>");
$result = mysql_query("DROP TABLE users")
or die("There was an error running the query !<br>");
echo("Table dropped!<br>");
$result = mysql_query("DROP TABLE temp_registrations")
or die("There was an error running the query !<br>");
echo("Table dropped!<br>");


/*
 * Create Entity-Model
 */
$result = mysql_query("CREATE TABLE users (id INT NOT NULL AUTO_INCREMENT, mobileNumber CHAR(66) UNIQUE, password CHAR(66), PRIMARY KEY(id))")
or die("There was an error running the query !<br>");
echo("Table users created!<br>");

$result = mysql_query("CREATE TABLE temp_registrations(id INT NOT NULL AUTO_INCREMENT, mobileNumber CHAR(66) UNIQUE, verCode CHAR(66), PRIMARY KEY(id))")
or die("There was an error running the query !<br>");
echo("Table temp_registrations created!<br>");

$result = mysql_query("CREATE TABLE contacts (contact_id INT NOT NULL AUTO_INCREMENT, origin_user_id INT NOT NULL, destination_user_id INT NOT NULL, nickname CHAR(66),
PRIMARY KEY(contact_id), FOREIGN KEY (destination_user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY (origin_user_id) REFERENCES users(id) ON DELETE CASCADE)")
or die("There was an error running the query! <br>");
echo("Table contacts created!<br>");

$result = mysql_query("CREATE TABLE messages (message_id INT NOT NULL AUTO_INCREMENT, contact_id INT NOT NULL, FOREIGN KEY (contact_id) REFERENCES contacts(contact_id), content CHAR(66), date_time TIMESTAMP, PRIMARY KEY(message_id))")
or die("There was an error running the query !<br>");
echo("Table messages created!<br>");

/*
 * Create Example Data
 */
$hashNumbersForTestUser = array('39f70f667f716efbaca8ff661766a427bb855aba56b7e28a5099d7048aac0f15', 'eea8f51875dd4c243b7a1783bb5aaabaae413a5774c08d3162de98162672e03c', '8eafddf4f4e0cd1571c6cd0e48fc82bfcc25d22af80495d500657c57671b3642');
$result = mysql_query("INSERT INTO users (id,mobileNumber,password) VALUES ('1','84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882','050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");
$result = mysql_query("INSERT INTO users (id,mobileNumber,password) VALUES ('2','0123456789','messenger'),('3','01514044001','messenger'),('4','0160987123','messenger'),('5','01418912302','messenger'),('20','" . $hashNumbersForTestUser[0] . "','unsicher'),('21','" . $hashNumbersForTestUser[1] . "','unsicher'),('22','" . $hashNumbersForTestUser[2] . "','unsicher')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

$result = mysql_query("INSERT INTO contacts (origin_user_id,destination_user_id,nickname) VALUES ('1','2','Hans Peter'),('1','3','Willi Schmidt'),('1','4','Max Mustermann'),('1','5','Julia König')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

$mysqlTimestamp = date('Y-m-d H:i:s');
$result = mysql_query("INSERT INTO messages (contact_id, content, date_time) VALUES ('1','Hallo ich bin Root','" . $mysqlTimestamp . "'),('1','Warum antwortest du nicht','" . $mysqlTimestamp . "'),('1','Dann halt nicht...','" . $mysqlTimestamp . "')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

//Close connection
mysql_close($connection);
echo("Connection closed!");
