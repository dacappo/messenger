<?php
include "dbconnection.php";
include "registration.php";
?>
<table border="2px">
    <thead>
    <tr>
        <td>TestCase</td>
        <td>Checked path</td>
        <td>Status</td>
    </tr>
    </thead>
    <tr>
        <td>Test user login</td>
        <td><?php
            if (checkLoginForUser('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882', '050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')) {
                echo("checkLoginForUser(): correct input </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("(): correct input </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?></td>
    </tr>
    <tr>
        <td>Test user login</td>
        <td><?php
            if (checkLoginForUser(' ', ' ') == false) {
                echo("checkLoginForUser(): wrong input </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkLoginForUser(): wrong input </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
    <tr>
        <td>Test SMS Gateway connection</td>
        <td><?php
            /* Check HTTP request to GATEWAY provider for registration */
            $number = generateRandNumber(12);
            $returnMessage = register($number, generateValidationString(5));
            echo (!strncmp($returnMessage, "OK", 2)) ?
                "register(): connection to SMS gateway provider  </td><td>  <span style='color:green'>successful</span><br></td>" :
                "register(): Error  </td><td>  <span style='color:red'>$returnMessage</span><br></td>";
            ?></td>
    </tr>
    <tr>
        <td>Check if user already exist</td>
        <td><?php
            if (checkDatabaseForUser('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882')) {
                echo("checkDatabaseForUser(): existing User </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkDatabaseForUser(): existing User </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
    <tr>
        <td>Check if user already exist</td>
        <td><?php
            if (checkDatabaseForUser(' ') == false) {
                echo("checkDatabaseForUser(): non existing User </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkDatabaseForUser(): non existing User </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
</table>

<h1>Register</h1>
<form name="input" action="register.php" method="post">
    Number: <input type="text" name="mobileNumber">
    <input type="submit" value="Submit">
</form>

<h1>Verfication</h1>
<form name="input2" action="check_ver.php" method="post">
    Number: <input type="text" name="mobileNumber">
    VerCode: <input type="text" name="verCode">
    <input type="submit" value="Submit">
</form>

<h1>Create User</h1>
<form name="input3" action="create_user.php.php" method="post">
    Number: <input type="text" name="mobileNumber">
    VerCode: <input type="text" name="password">
    <input type="submit" value="Submit">
</form>

<h1>Get contacts</h1>
<form name="input4" action="get_contacts.php" method="post">
    User ID: <input type="text" name="user_id">
    <input type="submit" value="Submit">
</form>
