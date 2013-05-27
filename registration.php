<?php

function register($mobileNumber, $generatedKey)
{
    $aErrorCodesSMS = array(10 => "No valid receiver", 20 => "No valid sender", 30 => "Messenge not valid", 40 => "Message route not correct", 50 => "Identification failed", 60 => "Balance too low", 70 => "Unsupported provider", 100 => "Successful");

    // +--------------------------------------------+
    // | Copyright (c) 2007-2009 by SMSTRADE.DE     |
    // +--------------------------------------------+
    $url = "http://gateway.smstrade.de"; // URL des Gateways
    $request = ""; // Request Variable initialisieren
    $param["key"] = "1265q4qhjeOQ3xth2R1nNy"; // Gateway Key
    $param["to"] = $mobileNumber; // Empfänger der SMS
    $param["message"] = "Ihr persönlicher Verifizierungscode lautet: " . $generatedKey; // Inhalt der Nachricht
    $param["route"] = "basic"; // Nutzung der Goldroute
    $param["from"] = "SMSTRADE"; // Absender der SMS
    $param["debug"] = "1"; // SMS wird nicht versendet - Testmodus

    foreach ($param as $key => $val) // Alle Parameter durchlaufen
    {
        $request .= $key . "=" . urlencode($val); // Werte müssen url-encoded sein
        $request .= "&"; // Trennung der Parameter mit &
    }

    // SMS kann jetzt versendet werden
    $response = @file($url . "?" . $request); // Request absetzen

    $response_code = intval($response[0]); // Responsecode auslesen

    if ($response_code != 100) {
        $responseMessage = $aErrorCodesSMS[$response_code];
        return $responseMessage;
    } else {
        if (!insertTempRegistration($mobileNumber,$generatedKey)){
            return "Server Error during registration";
        } else {
            return "OK"; //"SMS sent successfully.
        }
    }
}

function generateValidationString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function create_user($pNumber, $pPassword)
{
    $created = false;
    if (isset($pNumber) && isset($pPassword)) {
        $number = $pNumber;
        $ClientPassword = $pPassword;
    } else {
        return false;
    }

    //################################# Vielleicht noch auslagerbar
    $connection = initializeConnectionToDB();
    $path = parse_url(getenv("CLEARDB_DATABASE_URL"), PHP_URL_PATH);
    $db = substr($path, 1);

    $selected = mysql_select_db($db, $connection)
    or die("Could not select Database");
    //#################################

    $result = mysql_query("INSERT INTO users (mobileNumber,password) VALUES ('" . $number . "','" . $ClientPassword . "')")
    or die("There was an error running the query in create_user()!<br>");

    if (mysql_num_rows($result) <> 0) {
        $created = true;
    }

    mysql_close($connection);
    return $created;
}