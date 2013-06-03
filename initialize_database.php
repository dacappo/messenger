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

$result = mysql_query("CREATE TABLE messages (message_id INT NOT NULL AUTO_INCREMENT, contact_id INT NOT NULL, FOREIGN KEY (contact_id) REFERENCES contacts(contact_id), content VARCHAR(10000), date_time TIMESTAMP, read_status TINYINT(1) NOT NULL DEFAULT '0', PRIMARY KEY(message_id))")
or die("There was an error running the query !<br>");
echo("Table messages created!<br>");

/*
 * Create Example Data
 */
$hashNumbersForTestUser = array('39f70f667f716efbaca8ff661766a427bb855aba56b7e28a5099d7048aac0f15', 'eea8f51875dd4c243b7a1783bb5aaabaae413a5774c08d3162de98162672e03c', '8eafddf4f4e0cd1571c6cd0e48fc82bfcc25d22af80495d500657c57671b3642');
$result = mysql_query("INSERT INTO users (id,mobileNumber,password) VALUES ('1','84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882','050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");
$result = mysql_query("INSERT INTO users (id,mobileNumber,password) VALUES
                        ('2','9c9f57efe04f8f5a65b699db1c777238d5876b44cef240654c749dd09e1790ef','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('3','534a4a8eafcd8489af32356d5a7a25f88c70cfe0448539a7c42964c1b897a359','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('4','d5996b25e580c95b90cfc8a69898b31ee8edb66bea003ac99801b8cab34c2bb4','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('5','90bdb56dba0745a3236c1c38f185878fcdce441ee4e5ab171dfe0e08a6170016','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('6','34ce32f4cacdd770d6bb0977e066f74724b170f3ccf7002baa802170711f99df','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('7','a96fb099c9fe2b2866c515ce063539186c7103dd14b9df1a91741a7afd7f94fd','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('8','463222884392617ea340376783c428936fb6f5e93383822cc710bedfb4baf678','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('9','328ddd0ba464665d92fb01d9497bb5bdc63c273e2cc2e7fd99c4059facc502e5','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('10','a088eb5310fb57eb1ab36ceaa5f09bfa1414b38566a1d3624ef8f92d5caf0a95','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('11','d0199008beddcab7d895d7b43a9271ca9c7b622d21c647706eee967562798733','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('12','26c8d8ab4c9f6a73c78078a1eecae26a7d352b09e4e172427881802773ba73bd','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('13','fae8444eb29e989256b4316fab8896b850937aa4f3ebaa01f4f18f628fe9b016','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('14','e7b68195433e19cd6a3692d79e189a2200424d8c8afc50d39d2977d955c966e8','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('15','9096fca2c3cb906d420a8f9484ed9af14d39e3f8f419aee16cb6f675fa7f4e52','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('16','336ea308db1070f0312ed5678dc7a43dc619d0093ed5223b49e19195c4a5ccb9','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('17','2749019e074ad7369ea852b758e402fd23d491962bc24f146b7948a8ac8c4699','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('20','" . $hashNumbersForTestUser[0] . "','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('21','" . $hashNumbersForTestUser[1] . "','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),
                        ('22','" . $hashNumbersForTestUser[2] . "','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

$result = mysql_query("INSERT INTO contacts (origin_user_id,destination_user_id,nickname) VALUES
                        ('1','2','Michael Jackson'),
                        ('1','3','Johnny Depp'),
                        ('1','4','Will Smith'),
                        ('1','5','Lionel Messi'),
                        ('1','6','Barack Obama'),
                        ('1','7','James Cameron'),
                        ('1','8','JasonStatham'),
                        ('1','9','Rosie Hungtington'),
                        ('1','10','David Duchovny'),
                        ('1','11','Jessica Alba'),
                        ('1','12','Alesandra Ambrosio'),
                        ('1','13','Bill Gates'),
                        ('1','14','Charly Sheen'),
                        ('1','15','Megan Fox'),
                        ('2','1','Homer Simpson'),
                        ('2','3','Johnny Depp'),
                        ('2','4','Will Smith'),
                        ('2','5','Lionel Messi'),
                        ('2','6','Barack Obama'),
                        ('2','7','James Cameron'),
                        ('2','8','JasonStatham'),
                        ('2','9','Rosie Hungtington'),
                        ('2','10','David Duchovny'),
                        ('2','11','Jessica Alba'),
                        ('2','12','Alesandra Ambrosio'),
                        ('2','13','Bill Gates'),
                        ('2','14','Charly Sheen'),
                        ('2','15','Megan Fox'),
                        ('11','1','Homer Simson'),
                        ('11','2','Michael Jackson'),
                        ('11','16','Lukas Carullo')
                        ")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

$mysqlTimestamp = date('Y-m-d H:i:s');
$result = mysql_query("INSERT INTO messages (contact_id, content, date_time, read_status) VALUES ('1','Hallo ich bin Root','" . $mysqlTimestamp . "','0'),('1','Warum antwortest du nicht','" . $mysqlTimestamp . "','0'),('1','Dann halt nicht...','" . $mysqlTimestamp . "','0'),('2','Zurueck zu Origin','" . $mysqlTimestamp . "','0')")
or die("There was an error running the query !<br>");
echo("Example data ceated!<br>");

//Close connection
mysql_close($connection);
echo("Connection closed!");
