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
        <!-- Top bar user -->

        <!-- Top bar caption -->
        <div id="action_bar_caption">
		    <div id="action_bar_logo">
			    <span><img src="images/logo.png" class="action_bar_caption_icon" ></span>
		    </div>
		    <div id="action_bar_title">
			    <span>PaXaLu</span>
		    </div>
        </div>
	</div>


	
<script type="text/javascript">
/*
 Basic supporting functions
 */

function createElement(inType, inId, inClass) {
    var element = document.createElement(inType);
    element.setAttribute('id',inId);
    element.setAttribute('class',inClass);
    return element;
}

function createImgElement(inType, inId, inClass, inSrc) {
    var element = createElement(inType,inId, inClass);
    element.setAttribute('src',inSrc);
    return element;
}

function createContentElement(inType, inId, inClass, inContent) {
    var element = createElement(inType,inId, inClass);
    element.innerHTML = inContent;
    return element;
}


/*
some global stuff
*/

var userInfo = null;
var contactList = null;
var checkConversation = null;

var mobileNumber = '';
var userId = '';


/* Show login screen */
function showLoginScreen() {
    var login_container = createElement('div', 'login_container');
    var login_form = createElement('form','form_login');
    login_form.setAttribute('action','login.php');
    var login_info_message = createElement('div','login_info_message');
    var login_table = createElement('table','login_table');
    var tr1 = document.createElement('tr');
    var td1 = document.createElement('td');
    var img1 = document.createElement('img');
    img1.setAttribute('src','images/phone.png');
    var td2 = document.createElement('td');
    var input1 = createElement('input','input_mobile_number','input_text');
    input1.setAttribute('type','text');
    input1.setAttribute('name','mobile_number');
    input1.setAttribute('placeholder','Mobile number');
    var tr2 = document.createElement('tr');
    var td3 = document.createElement('td');
    var img2 = document.createElement('img');
    img2.setAttribute('src','images/keys.png');
    var td4 = document.createElement('td');
    var input2 = createElement('input','input_password','input_text');
    input2.setAttribute('type','password');
    input2.setAttribute('name','password');
    input2.setAttribute('placeholder','Password');
    var tr3 = document.createElement('tr');
    var td5 = document.createElement('td');
    var td6 = document.createElement('td');
    var input3 = createElement('input','button1','button');
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

    $('#action_bar_user').remove();
    $('#login_container').remove();
    $('#main').remove();

    document.body.appendChild(login_container);



        $("#form_login").submit(function(e) {
            e.preventDefault();
            mobileNumber = $("#input_mobile_number").val().toString();
            var encryptedNumber = CryptoJS.SHA256($("#input_mobile_number").val()).toString();
            var encryptedPassword = CryptoJS.SHA256($("#input_password").val()).toString();
            $.post($("#form_login").attr("action"), {number: encryptedNumber, password: encryptedPassword }, function(data){
                //do nothing
            });
            //Important. Stop the normal POST
            return false;
        });

}

function setInfoMessage(message, klass) {
    document.getElementById('login_info_message').setAttribute('class', klass);
    document.getElementById('login_info_message').innerHTML = message;
}

function createUserInfo(inNumber) {
    var action_bar_user = createElement('div','action_bar_user');
    var action_bar_user_icon = createImgElement('img','action_bar_user_icon','action_bar_user_icon','images/avatar2.png');
    var action_bar_user_status = createElement('div','action_bar_user_status');
    var button = createContentElement('div','button_logout','button','Logout');
    button.onclick = function() {
        loggedOut();
    }

    action_bar_user_status.appendChild(createContentElement('span','','','Logged in as '));
    action_bar_user_status.appendChild(createContentElement('span','','action_bar_user_status_number',inNumber));
    action_bar_user_status.appendChild(createContentElement('span','','',' !'));
    action_bar_user.appendChild(action_bar_user_icon);
    action_bar_user.appendChild(action_bar_user_status);
    action_bar_user.appendChild(button);

    document.getElementById('action_bar').insertBefore(action_bar_user, document.getElementById('action_bar_caption'));

    return this;
}


function createContactList() {

    $('#login_container').remove();

    var main = createElement('div','main');
    var contacts = createElement('div','contacts');
    var contact_list_head = createElement('div','contact_list_head');
    var icon = createImgElement('img', 'icon', 'icon','images/addressbook.png');
    var contact_list = createElement('div','contact_list');

    contact_list_head.appendChild(icon);
    contacts.appendChild(contact_list_head);
    contacts.appendChild(contact_list);
    main.appendChild(contacts);
    document.body.appendChild(main);


    $.post('get_contacts.php', {user_id: userId}, function(data){
        $.each( data.contacts.data , function( i, con ) {
            addContact(con.name, con.id);
        });
    });

    this.checkNewNotifications = function() {
        $.post('check_new_messages.php', {user_id: userId}, function(data){
            $.each(data.contact_IDs, function(i, conId) {
                setMessageNotification(conId);
            });
        });
    }

    this.setMessageNotification = function(inId) {

        if (!($('#notification'+inId).length > 0)) {
            var notification = createElement('div', 'notification' + inId, 'notification');
            document.getElementById('contact'+inId).appendChild(notification);
        }
    }

    this.removeMessageNotification = function(inId) {
        $('#notification'+inId).remove();
    }


    this.addContact = function(inName,inId){
        var contact = createElement('div','contact'+inId,'contact');
        contact.onclick = function() {
            createConversation(inName,inId);
        }
        var contact_name = createElement('span','contact_name','contact_name');
        var icon = createImgElement('img','contact_icon','contact_icon', 'images/avatar.png');


        contact.appendChild(icon);
        contact_name.appendChild(document.createTextNode(inName));
        contact.appendChild(contact_name);
        contact_list.appendChild(contact);
    }

    setInterval(checkNewNotifications, 1000);

    return this;
}



function createConversation(inName, inId) {

    clearInterval(checkConversation);

    contactList.removeMessageNotification(inId);

    var conversation = createElement('div','conversation');
    var conversation_info = createElement('div','conversation_info');
    var conversation_info_title = createElement ('div','conversation_info_title');
    var conversation_info_title_icon = createImgElement('img','','conversation_info_title_icon','images/avatar.png');
    var conversation_info_title_content = createContentElement('span','','',inName);
    var conversation_flow = createElement('div','conversation_flow');

    var conversation_input = createElement('form','conversation_input');
    var conversation_input_wrapper_field = createElement('div','conversation_input_wrapper_field');
    var conversation_input_field = createElement('input','conversation_input_field');
    conversation_input_field.setAttribute('type', 'text');
    var conversation_input_wrapper_button = createElement('div','conversation_input_wrapper_button');
    var conversation_input_button = createElement('input','conversation_input_button','button');
    conversation_input_button.setAttribute('type','submit');
    conversation_input_button.setAttribute('value','Send');

    conversation_info_title.appendChild(conversation_info_title_icon);
    conversation_info_title.appendChild(conversation_info_title_content);
    conversation_info.appendChild(conversation_info_title);


    conversation_input_wrapper_field.appendChild(conversation_input_field);
    conversation_input_wrapper_button.appendChild(conversation_input_button);
    conversation_input.appendChild(conversation_input_wrapper_field);
    conversation_input.appendChild(conversation_input_wrapper_button);

    conversation.appendChild(conversation_info);
    conversation.appendChild(conversation_flow);
    conversation.appendChild(conversation_input);

    // Update screen

    this.appendExternMessage = function(inName,inTime,inContent) {
        var message = createElement('div','','conversation_flow_extern_message');
        var message_title = createContentElement('div','','conversation_flow_message_title',inName);
        var message_time = createContentElement('div','','conversation_flow_message_time',inTime);
        var message_content = createContentElement('div','','conversation_flow_message_content',inContent);

        message.appendChild(message_title);
        message.appendChild(message_time);
        message.appendChild(message_content);

        conversation_flow.appendChild(message);
        conversation_flow.scrollTop = conversation_flow.scrollHeight;
    }

    this.appendInternMessage = function(inName,inTime,inContent) {
        var message = createElement('div','','conversation_flow_intern_message');
        var message_title = createContentElement('div','','conversation_flow_message_title',inName);
        var message_time = createContentElement('div','','conversation_flow_message_time',inTime);
        var message_content = createContentElement('div','','conversation_flow_message_content',inContent);

        message.appendChild(message_title);
        message.appendChild(message_time);
        message.appendChild(message_content);


        conversation_flow.appendChild(message);
        conversation_flow.scrollTop = conversation_flow.scrollHeight;
    }


    function checkNewMessages() {
        $.post('receive_messages.php', {contact_id: inId}, function(data){
            $.each(data.messages, function(i, message) {
                appendExternMessage(inName,message.timestamp, message.content);
                contactList.removeMessageNotification(inId);
            });
        });

    }

    $('#conversation').remove();

    document.getElementById('main').appendChild(conversation);

    $("#conversation_input").submit(function(e) {
        e.preventDefault();

        $.post('send_message.php', {body: conversation_input_field.value, contact_id: inId }, function(data){
         //do nothing
        });
        var date = new Date();
        appendInternMessage('Me',date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds(),conversation_input_field.value);
        conversation_input_field.value = '';
        conversation_input_field.focus();
        //Important. Stop the normal POST
        return false;
    });

    checkConversation = setInterval(checkNewMessages, 1000);

    return this;
}


function loggedOut() {
    $.ajax({url: "logout.php"});
    showLoginScreen();
    setInfoMessage('Successfully logged out!','info_message_success');
}

/*
Check server-side session
 */

<?php
	if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true) {

	    echo   'userInfo = createUserInfo(mobileNumber);
	            contactList = createContactList();
  				';
	} else {
	   /* echo   'createUserInfo(mobileNumber);
	            var contactList = createContactList();
	            var conversation = createConversation("Patrick Spiegel");
	            conversation.appendExternMessage("Patrick Spiegel","12:25:12","Hey, what is up guys?");
	            conversation.appendInternMessage("Lukas Carullo","12:25:12","Hey, everything is top!");
	            conversation.appendExternMessage("Patrick Spiegel","12:25:12","That sounds great! What should we do today");
	            conversation.appendInternMessage("Lukas Carullo","12:25:12","What we do every day! We try to rule the world :D");
	            conversation.appendExternMessage("Patrick Spiegel","12:25:12","Here we go ;)");
	            conversation.appendInternMessage("Lukas Carullo","12:25:12","Hey, everything is top!");
	            conversation.appendExternMessage("Patrick Spiegel","12:25:12","That sounds great! What should we do today");
	            conversation.appendInternMessage("Lukas Carullo","12:25:12","What we do every day! We try to rule the world :D");
	            conversation.appendExternMessage("Patrick Spiegel","12:25:12","Here we go ;)");
	            conversation.appendInternMessage("Lukas Carullo","12:25:12","Hey, everything is top!");
	            conversation.appendExternMessage("Patrick Spiegel","12:25:12","That sounds great! What should we do today");
	            conversation.appendInternMessage("Lukas Carullo","12:25:12","What we do every day! We try to rule the world :D");
	            conversation.appendExternMessage("Patrick Spiegel","12:25:12","Here we go ;)");
  				'; */
	    echo 'showLoginScreen();';

	}

?>

</script>
	
</body>

</html>
