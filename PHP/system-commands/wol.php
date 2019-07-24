<?php
# Wake on LAN - (c) HotKey@spr.at, upgraded by Murzik
# Modified by Allan Barizo http://www.hackernotcracker.com
//flush();

include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");
session_start();
if (!isset($_SESSION["username"])){
    echo("0");
    die("<h1>Unauthorized</h1>");
}

function WakeOnLan($broadcast, $mac){
    $cmd = "sudo etherwake " . $mac;
    shell_exec($cmd);
    
}

function ping($host,$port=22,$timeout=6)
{
        $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock )
        {
                return FALSE;
        }
        else
        {
                return TRUE;
        }
}


// Port number where the computer is listening. Usually, any number between 1-50000 will do. Normally people choose 7 or 9.
//$socket_number = "9";
// MAC Address of the listening computer's network device
$mac_addy = "00:1f:5b:3c:e6:18";
// IP address of the listening computer. Input the domain name if you are using a hostname (like when under Dynamic DNS/IP)
$ip_addy = "192.168.86.222";
 

$trys = 0;
$max_trys = 10;

while (ping($ip_addy) && $trys < $max_trys){
    //send wol packets until it is awake
    echo(WakeOnLan($ip_addy, $mac_addy));
    $trys += 1;
    sleep(0.5); //delay
}

if ($trys > ($max_trys - 1)){
    echo("0");
}
else{
    echo("1");
}





 
 
?>