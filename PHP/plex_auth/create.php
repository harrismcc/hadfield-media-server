<?php

//create a new plex account

/*
X-Plex-Product: Plex Web
X-Plex-Version: 3.106.2
X-Plex-Client-Identifier: 67uf8x3o7i8u1ed4fsodo9nd
X-Plex-Token: QfbH1B4ihpA7bG3sPRFw
*/

    //creates random id
function createid($n) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
    
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
    
        return $randomString; 
} 

function create_plex_user($email_in, $login_in, $password_in){


    //The url you wish to send the POST request to
    $url = 'https://plex.tv/api/v2/users';

    //The data you want to send via POST
    $fields = array('email' => $email_in, 'login' => $login_in, 'password' => $password_in);

    //plex client id to create users under
    //looks like this just needs to exist, but can basically be a random string...
    //$client_id = "97deb223-c6df-1a3e-b9f7-ccd68b60b58b";
    $client_id = createid(25);


    //url-ify the data for the POST
    $fields_string = http_build_query($fields);

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded", "X-Plex-Client-Identifier: " . $client_id));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

    //execute post
    $result = curl_exec($ch);

    if(curl_errno($ch)){
        return 'Curl error: ' . curl_error($ch);
    }

    //return http code. 201 means account created, 422 means account exists, 400 is bad request
    $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE);

    return $httpCode;
}

function invite_plex_user($plex_user_email){
    //The url you wish to send the POST request to
    $url = 'https://plex.tv/api/servers/39125569d7281c7ec7a57d94afa124027af31557/shared_servers';

    //The data you want to send via POST
    $fields = '{"server_id":"39125569d7281c7ec7a57d94afa124027af31557","shared_server":{"library_section_ids":[],"invited_email":"'. $plex_user_email .'"},"sharing_settings":{}}';

    //plex client id to create users under
    //looks like this just needs to exist, but can basically be a random string...
    //$client_id = "97deb223-c6df-1a3e-b9f7-ccd68b60b58b";
    $client_id = createid(25);

    //open connection
    $ch = curl_init();

    $username="harrismcc";
    $password="Cookie1212!";//TODO: again bad form, maybe there is a better way (token or something?)

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);   //basic auth
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", "X-Plex-Client-Identifier: " . $client_id));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);

    //So that curl_exec returns the contents of the cURL; rather than echoing it
    //curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

    //execute post
    $result = curl_exec($ch);

    if(curl_errno($ch)){
        return 'Curl error: ' . curl_error($ch);
    }

    //return http code. 201 means account created, 422 means account exists, 400 is bad request
    $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE);
    echo("Result: " . $result);
    return $httpCode;
}


////////INVITE USER////////
/*
TOKEN: X-Plex-Token=QfbH1B4ihpA7bG3sPRFw
^SEEMS LIKE BASIC AUTH WORKS HERE TOO, PROBABLY A BETTER OPTION
X-Request-Id: ec016d46-98e8-498a-8ba0-41a1e13a72f7
https://plex.tv/api/servers/39125569d7281c7ec7a57d94afa124027af31557/shared_servers?X-Plex-Product=Plex%20Web&X-Plex-Version=3.106.3&X-Plex-Client-Identifier=67uf8x3o7i8u1ed4fsodo9nd&X-Plex-Platform=Chrome&X-Plex-Platform-Version=75.0&X-Plex-Sync-Version=2&X-Plex-Features=external-media&X-Plex-Model=hosted&X-Plex-Device=Windows&X-Plex-Device-Name=Chrome&X-Plex-Device-Screen-Resolution=852x862%2C1500x1000&X-Plex-Token=QfbH1B4ihpA7bG3sPRFw&X-Plex-Language=en
{"server_id":"39125569d7281c7ec7a57d94afa124027af31557","shared_server":{"library_section_ids":[],"invited_email":"test123test123"},"sharing_settings":{}}

*/