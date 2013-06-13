<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheets/overall.css">
    <link rel="stylesheet" type="text/css" " href="stylesheets/default.css">
    <style type="text/css">
        body {
            font-style:normal;
            background-image:url("http://www.planet-source-code.com/vb/2010Redesign/images/LangugeHomePages/PHP.png");
            background-repeat:no-repeat;
            background-position:center center;
            background-size: 20%;
            background-color: lavender;
             }
    </style>
    <title></title>
</head>
<body>
<?php
include "dbconnection.php";
include "registration.php";
?>
<h1>PHP Unit tests - PaXaLu messenger</h1>

<h2>Test Case: Login</h2>
<table border="2px">
    <thead>
    <tr>
        <td>Test Case</td>
        <td>Detail</td>
        <td>Status</td>
    </tr>
    </thead>
    <tr>
        <td>Test Case: User login</td>
        <td><?php
            if (checkLoginForUser('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882', '050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')) {
                echo("checkLoginForUser(): correct input </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("(): correct input </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?></td>
    </tr>
    <tr>
        <td>Test Case: User login</td>
        <td><?php
            if (checkLoginForUser(' ', ' ') == false) {
                echo("checkLoginForUser(): wrong input </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkLoginForUser(): wrong input </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
</table>

<h2>Test Case: Registration</h2>
<table border="2px">
    <thead>
    <tr>
        <td>Test Case</td>
        <td>Detail</td>
        <td>Status</td>
    </tr>
    </thead>
    <tr>
        <td>Test SMS Gateway connection and creating of a temporary user</td>
        <td><?php
            /* Check HTTP request to GATEWAY provider for registration */
            $number = generateRandNumber(12);
            $returnMessage = register($number, generateValidationString(5));
            echo (!strncmp($returnMessage, "OK", 2)) ?
                "register(): Test connection to SMS gateway provider  </td><td>  <span style='color:green'>successful</span><br></td>" :
                "register(): Error  </td><td>  <span style='color:red'>$returnMessage</span><br></td>";
            ?></td>
    </tr>
    <tr>
        <td>Check if user already exist</td>
        <td><?php
            if (checkDatabaseForUser('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882') <> 0) {
                echo("checkDatabaseForUser(): existing User </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkDatabaseForUser(): existing User </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
    <tr>
        <td>Check if user already exist</td>
        <td><?php
            if (checkDatabaseForUser(' ') == 0) {
                echo("checkDatabaseForUser(): non existing User </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkDatabaseForUser(): non existing User </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
    <tr>
        <td>Check if a user can be created with valid data</td>
        <td><?php
            $mobileNumber = generateRandNumber(12);;
            $password = "test";
            if (strpos(create_user($mobileNumber, $password), "OK") === 0) {
                echo("create_user(): valid data </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("create_user(): valid data </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
</table>

<h2>Test Case: Show Contacts</h2>
<table border="2px">
    <thead>
    <tr>
        <td>Test Case</td>
        <td>Detail</td>
        <td>Status</td>
    </tr>
    </thead>
    <tr>
        <td>Look for an contact with a registered number</td>
        <td><?php
            $user_id = 1;
            $JSON = '[ { "number" : "01514044001" , "name" :  "hansi" }]';
            $arrayOfContacts = json_decode($JSON, true);
            $matchedContacts = compare_contacts($arrayOfContacts,$user_id);
            if (!emtpty($matchedContacts)) {
                echo("compare_contacts(): existing contact </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("compare_contacts(): existing contact </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
    <tr>
        <td>Look for an contact with an unknown number</td>
        <td><?php
            $user_id = 1;
            $JSON = '[ { "number" : "02344232144444441" , "name" :  "hansi" }]';
            $arrayOfContacts = json_decode($JSON, true);
            $matchedContacts = compare_contacts($arrayOfContacts,$user_id);
            if (emtpty($matchedContacts)) {
                echo("compare_contacts(): unknown number </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("compare_contacts(): unknown number </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
</table>
</body>
</html>
