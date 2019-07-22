<?php

$PLEX_TOKEN = "ZcY_pN6EbZeuPqqDkiyV";

////////GET ID'S FROM PLEX////////

$request = "http://hadfield.webhop.me:32400/library/sections/1/all?X-Plex-Token=" . $PLEX_TOKEN;
$contents = file_get_contents($request);

$xml = simplexml_load_string($contents);


//array of id's that are in plex
$existing_ids = array();

//gather all imdb id's of items in plex and populate array
for ($i = 0; $i < sizeof($xml->Video); $i++){


    $v = substr((string)$xml->Video[$i]["guid"],28,7);
    array_push($existing_ids, $v);
    echo($existing_ids);
}

////////MATCH TO REQUESTS////////


//new sql connection
include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//get all rows where there is and imdb id and it is not complete
$sql="SELECT * FROM `requests_table` WHERE `imdb_id` IS NOT NULL AND `complete` = 0";
$result = $con->query($sql);

while ($row = $result->fetch_assoc()) {
    //check if this id is in the above array (aka in plex)
    if (in_array($row["imdb_id"], $existing_ids)){
        //update db
        $new_sql = "UPDATE `requests_table` SET `complete` = '1' WHERE `requests_table`.`id` = " . $row["id"];
        $con->query($new_sql);
        echo("updated 1 item");
    }

}

die("done");