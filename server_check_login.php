<?php


/* 
* User Login
*/

// Get number and passwort 
if (isset ($_GET["number"]) && isset ($_GET["password"])) {
	$postNumber = $_GET["number"];
	$postPassword = $_GET["password"];
} else {
	echo "number or password is missing";
}

class Controller {
	public $password;
	public $number;

	public function __consruct() {

	}

	public function encrypt_data($sNumber, $sPassword) {
		// noch entschluesselung einbauen
		$this->number = $sNumber;
		$this->password = $sPassword;
	}

}

$controller = new Controller();
$controller->encrypt_data($postNumber, $postPassword);
echo "Number: " . $controller->number . "<br>";
echo "Password: " . $controller->password . "<br>";

// Connecting, selecting database

$mysqli = new mysqli("127.0.0.1", "user00", "password", "messenger");
/* check connection */
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit ();
}

// Performing SQL query
$query = 'SELECT * FROM user WHERE ' . 'number=\'' . $controller->number . '\' AND password=\'' . $controller->password . '\'';
echo $query . " <br> <br> ";

if ($result = $mysqli->query($query)) {

	/* fetch object array */
	while ($row = $result->fetch_row()) {
		echo "Size of row array: " . count($row) . " <br> ";
		echo $row[0] . " " . $row[1] . " " . $row[2];
	}

	/* free result set */
	$result->close();
}

/* close connection */
$mysqli->close();
?>

