<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 15.06.13
 * Time: 09:45
 */

include "messenger.php";

$user_id = $_POST['user_id'];

if (!isset($user_id)) {
    echo "Not all required POST parameter set!";
}

echo check_for_contacts($user_id);





