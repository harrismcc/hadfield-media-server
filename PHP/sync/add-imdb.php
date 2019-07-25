<?php

/* This script goes through the requests db and adds imdb id's to all items where the id is NULL
*       It uses the omdb api to search by title and assign matching imdb id's of one exists
*       Then it updates each entry in the db
*/


error_reporting( E_ALL );

include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");
/*
// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}*/
$con= get_connection('requests');

//create and execute the sql line
//only get lines where a link exists
//TODO: add support for lines with magnet links
$sql="SELECT *  FROM `requests_table` WHERE `imdb_id` IS NULL OR `imdb_id` = ''";
$result = $con->query($sql);

while ($row = $result->fetch_assoc()) {
    //Format search string
    $row["name"] = str_replace(' ', '%20', $row["name"]);

    //search with omdb api
    $request = "https://www.omdbapi.com/?apikey=7d893962&s=" . $row["name"];
    $contents = file_get_contents($request);

    //if something is returned
    if ($contents){
        //decode result into json
        $my_json = json_decode($contents, true);

        //grab imdb id and remove leading "tt"
        $new_id = str_replace('tt', '', $my_json["Search"][0]["imdbID"]);

        //update in the db
        $new_sql = "UPDATE `requests_table` SET `imdb_id` = '" . $new_id . "' WHERE `requests_table`.`id` = " . $row["id"];
        $con->query($new_sql);
    }
    
}

die("done");