<?php
include "dbconnection.php";
include "registration.php";
?>
<table border="2px">
    <thead>
    <tr>
        <td>TestCase</td>
        <td>Status</td>
    </tr>
    </thead>
    <tr>
        <td>Test valid user login</td>
        <td><?php
            if (checkDatabaseForUser('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882', '050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')) {
                echo("checkDatabaseForUser(): correct input </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkDatabaseForUser(): correct input </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?></td>
    </tr>
    <tr>
        <td>Test incorrect user login</td>
        <td><?php
            if (checkDatabaseForUser(' ', ' ') == false) {
                echo("checkDatabaseForUser(): wrong input </td><td> <span style='color:green'>successful</span><br></td>");
            } else {
                echo("checkDatabaseForUser(): wrong input </td><td> <span style='color:red'>not successful</span><br></td>");
            }
            ?>
    </tr>
    <tr>
        <td>Test SMS Gateway connection</td>
        <td><?php
            /* Check HTTP request to GATEWAY provider for registration */
            $returnMessage = register("015140445799", generateValidationString(5));
            echo (!strncmp($returnMessage, "OK", 2)) ?
                "register(): connection to SMS gateway provider = <span style='color:green'>successful $returnMessage</span><br>" :
                "register(): Error => <span style='color:red'>$returnMessage</span><br>";
            ?></td>
    </tr>
</table>