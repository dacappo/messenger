<?php
/* 
* User Login
*/

// Get number and passwort 
$postNumber = $_POST[$number];
$postPasswort = $_POST[$password];

class Controller {
	private $password;
	private $number;

	public function __consruct() {

	}

	public function encrypt_data($sNumber, $sPasswort) {
		// noch entschluesselung einbauen
		this->number = $sNumber;
		this->password = $sPasswort;
	}

}

$controller = new Controller();
$controller->encrypt_data($postNumber, $postPasswort);

// Connecting, selecting database
$link = mysql_connect('127.0.0.1', 'client', 'password')
    or die('Could not connect: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db('messenger') or die('Could not select database');

// Performing SQL query
$query = 'SELECT * FROM user WHERE number=$controller->$number AND password=$controller->$password';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

echo $result;

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>

