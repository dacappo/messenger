<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 28.05.13
 * Time: 08:50
 * To change this template use File | Settings | File Templates.
*/

session_start();

// Create a new session object if its a new session
if (!isset($_COOKIE['session'])) {
    setcookie("session", $_POST['test'], time() + 31536000);
    echo $_COOKIE['session'];
}