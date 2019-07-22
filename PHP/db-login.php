<?php

//This is used to store the login credentials for other scripts

//new sql connection
$servername = "localhost";

$username = 'hadfield_php_agent';
$password = 'a383pmojPjbqtKUoRdfyhwstfEVz9K';

$dbname = "requests";

// Function to check response time
function pingDomain1($domain){
    $starttime = microtime(true);
    $file      = fsockopen ($domain, 80, $errno, $errstr, 10);
    $stoptime  = microtime(true);
    $status    = 0;

    if (!$file) $status = -1;  // Site is down
    else {
        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
        $status = floor($status);
    }
    return $status;
}

if (pingDomain1($servername) < 0){
    //database could not connect, backup here
    $servername = 'localhost'; //TODO: ADD BACKUP SERVER OR ALTERNATE ADDRESS HERE
}
