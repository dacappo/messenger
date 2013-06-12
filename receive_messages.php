<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 12.06.13
 * Time: 15:53
 */

include "messenger.php";

$contact_id = $_POST['contact_id'];
$timestamp = $_POST['timestamp'];

if (!isset($timestamp)){
    $timestamp = date('Y-m-d H:i:s');
} elseif (!isset($contact_id)){
    echo "Not all required POST parameters set";
}
// TODO Timestamp benuten
$messagesJSON = getMessages($contact_id, $timestamp);

if (!isset($messagesJSON) || $messagesJSON == ' '){
    echo "NO messages found!" ;
} else {
    echo $messagesJSON;
}