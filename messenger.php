<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 29.05.13
 * Time: 13:51
 */

function show_contacts($pUser_id){

    if (isset($pNumber) && isset($pPassword)) {
        $user_id = $pUser_id;
    } else {
        return "ERROR : No valid parameter";
    }

    $contacts = getContactsForUserID($user_id);

    return $contacts;
}