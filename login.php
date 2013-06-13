<?php

    require "dbconnection.php";
	
	$posNumber = $_POST['number'];
	$posPassword = $_POST['password'];
	$suc = false;

    if (checkLoginForUser($posNumber, $posPassword)) {
		session_start();
		$_SESSION['loggedIn']=true;
		$suc = true;
	}

	header ("content-type: text/javascript");
	
	if($suc) {
				
 		echo 	'createUserInfo(mobileNumber);
	            createContactList();
  				';
 	} else {
 		echo 	'showLoginScreen();
 		         setInfoMessage("Wrong number or password!","info_message_warning");';
	}
