<?php
$url = 'https://plex.tv/users/sign_in.json';
$data = array('user[login]' => 'harrismcc', 'user[password]' => 'Cookie1212!');

/*

X-Plex-Product: Plex Web
X-Plex-Version: 3.106.2
X-Plex-Client-Identifier: 67uf8x3o7i8u1ed4fsodo9nd
http_build_query($data)
*/

$options = array(
    'http' => array(
        'header'  => "X-Plex-Product: Plex Web; X-Plex-Version: 3.106.2; X-Plex-Client-Identifier: 67uf8x3o7i8u1ed4fsodo9nd;",
        'method'  => 'POST',
        'body' => 'user%5Blogin%5D=plexusername&user%5Bpassword%5D=myplexpassword'
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);