
<?php 


?>
<!DOCTYPE html>
<html>

<head>

	<!-- Meta information -->
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>PaXaLu</title>
	<link rel="icon" type="image/png" href="images/logo.png">
	
	<!-- Scripts & libraries -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js"></script
	
	<!-- Cascading style sheets -->
	<link rel="stylesheet" type="text/css" href="stylesheets/overall.css">
	<link rel="stylesheet" type="text/css" " href="stylesheets/default.css">
	<!--<link rel="stylesheet" type="text/css" media="screen and (min-width: 10cm) and (max-width: 25cm)" href="stylesheets/tablet.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 10cm)" href="stylesheets/smartphone.css">
	media="screen and (min-width: 25cm)-->

</head>	 
<body>
	<div id="action_bar">
		<div id="action_bar_logo">
			<span><img src="images/logo.png" style="height:30px"></span>
		</div>
		<div id="action_bar_title">
			<span>PaXaLu</span>
		</div>
	</div>
	
	<div id="conversation">
		
		<form id="form_login" action="login.php">
		<div id="login_info_message" class="info_message_warning" style="visibility:hidden; height: 0px"></div>
		<table>
			<tr>
				<td><img src="images/phone.png"></td> 
				<td ><input id="input_mobile_number" class="input_text" type="text" name="mobile_nubmer" placeholder="Mobile number"></td> 
			</tr>
			<tr>
				<td><img src="images/keys.png"></td> 
				<td><input id="input_password" class="input_text" type="password" name="password" placeholder="Password" ></td>
			</tr>
			<tr>
				<td></td>
 				<td><input class="button" type="submit" value="Submit"></td>
			</tr>
					
		</table> 		 
 		 
 		</form>
	
	
	</div>
	
<script type="text/javascript">
	$(document).ready(function(){
			
    	$("#form_login").submit(function(e) {
    		e.preventDefault();
    		var encryptedNumber = CryptoJS.SHA256($("#input_mobile_number").val()).toString();
    		var encryptedPassword = CryptoJS.SHA256($("#input_password").val()).toString();
        	$.post($("#form_login").attr("action"), {number: encryptedNumber, password: encryptedPassword }, function(data){
            	          	
        	});
       		//Important. Stop the normal POST
        	return false;
    	});
	});
	
<?php
    session_start();
	if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true) {
	
		echo   'var message = document.createElement("div");
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
 				    document.getElementById("action_bar").removeChild(document.getElementById("button_logout"));
 				    var message = document.createElement("div");
 				    message.innerHTML = "Successfully logged out!";
 				    message.setAttribute("class","info_message_success");
 				    message.setAttribute("id","login_info_message");
 				    document.getElementById("form_login").innerHTML = "";
 				    document.getElementById("form_login").appendChild(message);

 				};

 				document.getElementById("action_bar").appendChild(button);
  				';
	}

?>

</script>
	
</body>

</html>
