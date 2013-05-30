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


    <!--
    <div id="conversation">
    </div>
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
        login_container.setAttribute('id','login_container')
        var login_form = document.createElement('form');
        login_form.setAttribute('id','form_login');
        login_form.setAttribute('action','login.php');
        var login_info_message = document.createElement('div');
        login_info_message.setAttribute('id','login_info_message');
        var login_table = document.createElement('table');
        login_table.setAttribute('id','login_table');
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


        $('#login_container').remove();

        //$('#main').appendChild(login_container);
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

    function setInfoMessage(message, klass) {
        document.getElementById('login_info_message').setAttribute('class', klass);
        document.getElementById('login_info_message').innerHTML = message;
    }

    function showContacts() {
        $('#login_container').remove();

        var main = document.createElement('div');
        main.setAttribute('id','main');
        var contacts = document.createElement('div');
        contacts.setAttribute('id','contacts');
        var contact_list_head = document.createElement('div');
        contact_list_head.setAttribute('id','contact_list_head');
        contact_list_head.innerHTML = "Contacts";
        var contact_list = document.createElement('div');
        contact_list.setAttribute('id','contact_list');

        contacts.appendChild(contact_list_head);
        contacts.appendChild(contact_list);

        main.appendChild(contacts);

        document.body.appendChild(main);

        $.post('contacts.php', {user_id: 1}, function(data){
            $.each( data.contacts, function( i, contact ) {
                var contact = document.createElement('div');
                contact.setAttribute('class','contact');
                var contact_name = document.createElement('span');
                contact_name.setAttribute('class',contact.name);
                var icon = document.createElement('img');
                icon.setAttribute('src','images/avatar.png');
                icon.setAttribute('class','contact_icon');

                contact_name.appendChild(icon);

                contact_name.appendChild(document.createTextNode('Max Mustermann'));
                contact.appendChild(contact_name);

                contact_list.appendChild(contact);
            }
        });




    }





/*<div id="main">
    <div id="contacts">
        <div id="contact_list_head">
            Contacts
        </div>
        <div id="contact_list">
            <div class="contact">
                <span class="contact_name"><img src="images/avatar.png" style="height:15px; margin:5px 5px 0px 5px"/>Max Mustermann</span>
            </div>
        </div>
    </div>

*/





function loggedOut() {
    $.ajax({url: "logout.php"});
    showLoginScreen();
    document.getElementById("action_bar_center").removeChild(document.getElementById("button_logout"));
    setInfoMessage('Successfully logged out!','info_message_success');

}

/*
Check server-side session
 */

<?php
	if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true) {
	
		echo   'showLoginScreen();
		        var message = document.createElement("div");
		        $("#login_table").remove();
		        setInfoMessage("Successfully logged in!","info_message_success");

 				var button = document.createElement("div");
 				button.innerHTML = "Logout";
 				button.setAttribute("class","button");
 				button.setAttribute("id","button_logout");
 				button.onclick = function() {
 				    loggedOut();
                }
 				document.getElementById("action_bar_center").appendChild(button);
  				';
	} else {
	    echo 'showLoginScreen();
	          showContacts();';
	}

?>

</script>
	
</body>

</html>
