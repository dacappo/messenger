<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 11.06.13
 * Time: 21:21
 */

include "messenger.php";

$contact_id = $_POST['contact_id'];
$body = $_POST['body'];
$timestamp = $_POST['timestamp'];

if (!isset($contact_id) || !isset($body) || !isset($timestamp)) {
    echo "Not all required POST parameters are set";
}

$messageData = array($contact_id, $timestamp, $body);

if (sendMessage($messageData)){
    echo "OK";
} else {
    echo "Server Error";
}