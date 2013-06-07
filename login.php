<?php

    require "dbconnection.php";
	
	$posNumber = $_POST['number'];
	$posPassword = $_POST['password'];
	$suc = false;

    $userId = checkLoginForUser($posNumber, $posPassword);
    if ($userId > 0) {
		session_start();
		$_SESSION['loggedIn']=true;
		$suc = true;
	}

	header ("content-type: text/javascript");
	
	if($suc) {
				
 		echo 	'userInfo =createUserInfo(mobileNumber);
 		         userId = ' . $userId . ';
	             contactList = createContactList();
  				';
 	} else {
 		echo 	'setInfoMessage("Wrong number or password!","info_message_warning");';
	}
