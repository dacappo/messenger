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


/*
 * Clear existing Tables
 */
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
$result = mysql_query("CREATE TABLE users(id INT NOT NULL AUTO_INCREMENT, mobileNumber CHAR(66), password CHAR(66), PRIMARY KEY(id))")
or die("There was an error running the query !<br>");
echo("Table users created!<br>");

$result = mysql_query("CREATE TABLE temp_registrations(id INT NOT NULL AUTO_INCREMENT, mobileNumber CHAR(66), verCode CHAR(66), PRIMARY KEY(id))")
or die("There was an error running the query !<br>");
echo("Table temp_registrations created!<br>");

$result = mysql_query("CREATE TABLE contacts (contact_id INT NOT NULL AUTO_INCREMENT, source_user_id INT NOT NULL, origin_user_id INT NOT NULL, nickname CHAR(66),
PRIMARY KEY(contact_id), FOREIGN KEY ON DELETE CASCADE (source_user_id) REFERENCES users(id), FOREIGN KEY ON DELETE CASCADE (origin_user_id) REFERENCES users(id))")
or die("There was an error running the query! <br>");
echo("Table contacts created!<br>");

/*
 * Create Example Data
 */
$result = mysql_query("INSERT INTO users (mobileNumber,password) VALUES ('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882','050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");
$result = mysql_query("INSERT INTO users (mobileNumber,password) VALUES ('0123456789','messenger')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

$result = mysql_query("INSERT INTO temp_registrations (mobileNumber,verCode) VALUES ('0123456789','01234')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

$result = mysql_query("INSERT INTO contacts (source_user_id,origin_user_id,nickname) VALUES ('1','2','Bestfriend')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

//Close connection
mysql_close($connection);
echo("Connection closed!");
