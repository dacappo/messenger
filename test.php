<?php
include "check_login.php";

if (check_database('84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882','050f993ea2322d4b6940f8560a253a11709fdc5ab08fd994bceb096846ea1645')) {
    echo("check_database: <span style='color:green'>successful</span><br>");
} else {
    echo("check_database: <span style='color:red'>not successful</span><br>");
}