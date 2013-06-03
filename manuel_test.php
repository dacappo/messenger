<?php

$contacts = '[{ "number" : "112323542356" , "name" : "Patrick" } , { "number" : "11232123444444" , "name" : "retig" }]';

$arrayOfContacts = json_decode($contacts, true);

echo $contacts;
echo "<br>";

$decContacts = array();
foreach ($arrayOfContacts as $contact) {
    $decContacts[$contact['number']] = $contact['name'];
}

$matchedContacts = array();
foreach ($decContacts as $key => $val){
    if (true){
        $matchedContacts[] = $val;
    }
}

var_dump($matchedContacts);