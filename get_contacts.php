<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 30.05.13
 * Time: 14:32
 * To change this template use File | Settings | File Templates.
 */

include "messenger.php";

$user_ID = $_POST['user_id'];

$resultDataJSON = show_contacts($user_ID);

header('Content-Type: application/json');

echo $resultDataJSON;