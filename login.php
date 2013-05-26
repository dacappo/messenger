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
				
 		echo 	'
 		        var message = document.createElement("div");
 				message.innerHTML = "Successfully logged in!";
 				message.setAttribute("class","info_message_success");
 				message.setAttribute("id","login_info_message");
 				document.getElementById("form_login").innerHTML = "";
 				document.getElementById("form_login").appendChild(message);
 				var button = document.createElement("div");
 				button.innerHTML = "Logout";
 				button.setAttribute("class","button");
 				button.setAttribute("id","button_logout");
 				button.onclick = function(){
 				    $.ajax({url: "logout.php"});
 				    document.getElementById("action_bar_center").removeChild(document.getElementById("button_logout"));
 				    var message = document.createElement("div");
 				    message.innerHTML = "Successfully logged out!";
 				    message.setAttribute("class","info_message_success");
 				    message.setAttribute("id","login_info_message");
 				    document.getElementById("form_login").innerHTML = "";
 				    document.getElementById("form_login").appendChild(message);

 				};

 				document.getElementById("action_bar_center").appendChild(button);
  				';
 	} else {
 		echo 	'
 				var message = document.createElement("div");
 				message.innerHTML = "Wrong number or password!";
 				message.setAttribute("class","info_message_warning");
 				message.setAttribute("id","login_info_message");
 				document.getElementById("form_login").replaceChild(message, document.getElementById("login_info_message"));
  				';
	}
