<?php    session_start(); ?>

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
    <!-- Top bar -->
	<div id="action_bar">
    <div id="action_bar_center">
		<div id="action_bar_logo">
			<span><img src="images/logo.png" style="height:30px"></span>
		</div>
		<div id="action_bar_title">
			<span>PaXaLu</span>
		</div>
    </div>
	</div>

    <!-- Login fields
	<div>
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
	-->
	
<script type="text/javascript">
/*
Override login submit
*/
    function overrideLoginSubmit() {

    $("#form_login").submit(function(e) {
        e.preventDefault();
        var encryptedNumber = CryptoJS.SHA256($("#input_mobile_number").val()).toString();
        var encryptedPassword = CryptoJS.SHA256($("#input_password").val()).toString();
        $.post($("#form_login").attr("action"), {number: encryptedNumber, password: encryptedPassword }, function(data){

        });
        //Important. Stop the normal POST
        return false;
    });
}
/* Show login screen */
    function showLoginScreen() {
        var login_container = document.createElement('div');
        var login_form = document.createElement('form');
        login_form.setAttribute('id','form_login');
        login_form.setAttribute('action','login.php');
        var login_info_message = document.createElement('div');
        login_info_message.setAttribute('id','login_info_message');
        var login_table = document.createElement('table');
        var tr1 = document.createElement('tr');
        var td1 = document.createElement('td');
        var img1 = document.createElement('img');
        img1.setAttribute('src','images/phone.png');
        var td2 = document.createElement('td');
        var input1 = document.createElement('input');
        input1.setAttribute('id','input_mobile_number');
        input1.setAttribute('class','input_text');
        input1.setAttribute('type','text');
        input1.setAttribute('name','mobile_number');
        input1.setAttribute('placeholder','Mobile number');
        var tr2 = document.createElement('tr');
        var td3 = document.createElement('td');
        var img2 = document.createElement('img');
        img2.setAttribute('src','images/keys.png');
        var td4 = document.createElement('td');
        var input2 = document.createElement('input');
        input2.setAttribute('id','input_password');
        input2.setAttribute('class','input_text');
        input2.setAttribute('type','password');
        input2.setAttribute('name','password');
        input2.setAttribute('placeholder','Password');
        var tr3 = document.createElement('tr');
        var td5 = document.createElement('td');
        var td6 = document.createElement('td');
        var input3 = document.createElement('input');
        input3.setAttribute('class','button');
        input3.setAttribute('type','submit');
        input3.setAttribute('value','Login');
        login_form.appendChild(login_table);
        login_container.appendChild(login_form);


        td1.appendChild(img1);
        td2.appendChild(input1);
        td3.appendChild(img2);
        td4.appendChild(input2);
        td6.appendChild(input3);

        tr1.appendChild(td1);
        tr1.appendChild(td2);
        tr2.appendChild(td3);
        tr2.appendChild(td4);
        tr3.appendChild(td5);
        tr3.appendChild(td6);

        login_table.appendChild(tr1);
        login_table.appendChild(tr2);
        login_table.appendChild(tr3);

        login_form.appendChild(login_info_message);
        login_form.appendChild(login_table);

        login_container.appendChild(login_form);

        document.body.appendChild(login_container);

        $("#form_login").submit(function(e) {
            e.preventDefault();
            var encryptedNumber = CryptoJS.SHA256($("#input_mobile_number").val()).toString();
            var encryptedPassword = CryptoJS.SHA256($("#input_password").val()).toString();
            $.post($("#form_login").attr("action"), {number: encryptedNumber, password: encryptedPassword }, function(data){

            });
            //Important. Stop the normal POST
            return false;
        });

    }

showLoginScreen();

/*
Check server-side session
 */
<?php

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
	}

?>

</script>
	
</body>

</html>
