<?php

    include "check_login.php";
	
	$PostNumber = $_POST['number'];
	$PostPassword = $_POST['password'];
	$success = false;


    $bool = check_database($PostNumber,$PostPassword);

    if ($bool) {
		session_start();		
		$_SESSION['loggedIn']=true;
		$success = true;
	}

	header ("content-type: text/javascript");
	
	if($success) {
				
 		echo 	'
 		        var message = document.createElement("div");
 				message.innerHTML = "Succesfully logged in!";
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
 				    document.getElementById("action_bar").removeChild(document.getElementById("button_logout"));
 				    var message = document.createElement("div");
 				    message.innerHTML = "Succesfully logged out!";
 				    message.setAttribute("class","info_message_success");
 				    message.setAttribute("id","login_info_message");
 				    document.getElementById("form_login").innerHTML = "";
 				    document.getElementById("form_login").appendChild(message);

 				};

 				document.getElementById("action_bar").appendChild(button);
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
