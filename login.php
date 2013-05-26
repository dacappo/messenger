<?php

    require "dbconnection.php";
	
	$posNumber = $_POST['number'];
	$posPassword = $_POST['password'];
	$success = false;




    if ($posNumber == '84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882' && $posPassword == '050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645') {
		session_start();
		$_SESSION['loggedIn']=true;
		$success = true;
	}

	header ("content-type: text/javascript");
	
	if($success) {
				
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
