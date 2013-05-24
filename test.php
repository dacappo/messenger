<?php
include "check_login.php";
include "registration.php";

if (check_database('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882','050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')) {
    echo("check_database(): correct input = <span style='color:green'>successful</span><br>");
} else {
    echo("check_database(): correct input = <span style='color:red'>not successful</span><br>");
}

if (check_database(' ',' ') == false) {
    echo("check_database(): wrong input = <span style='color:green'>successful</span><br>");
} else {
    echo("check_database(): wrong input = <span style='color:red'>not successful</span><br>");
}

/* Check HTTP request to GATEWAY provider for registration */
$returnMessage = register("015140445799", generateValidationString(5));
echo (!strncmp($returnMessage, "OK", 2)) ?
  "register(): connection to SMS gateway provider = <span style='color:green'>successful $returnMessage</span><br>" :
  "register(): Error => <span style='color:red'>$returnMessage</span><br>";
