<?php

//this endpoint takes an imdb id OR a YTS torrent id and returns the status
    //in db, complete

require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");  

//check if imdb id is in db and return result
function imdb_id_check($imdb_id_raw){
    $imdb_id = str_replace("tt", "", $imdb_id_raw); //remove "tt"

        
    $con = get_connection('requests');

    $sql = "SELECT * FROM `requests_table` WHERE `imdb_id` = " . $imdb_id . " AND `complete` = 1";
    $result = $con->query($sql);

    //TODO: currently this returns everything, including username. Should we filter this result?
    if($result){
        while ($row = $result->fetch_assoc()){
            return json_encode(array("result" => true, "data" => $row)); //return the row. "die" to ensure only one result
        }
        return json_encode(array("result" => false));
    }
    else{
        return json_encode(array("result" => false));
    }
}


if (isset($_GET['imdb_id'])){

    echo(imdb_id_check($_GET['imdb_id']));
}

//try yts id as second option after imdb id
if (isset($_GET['yts_id'])){
    $result_raw = file_get_contents("https://yts.lt/api/v2/movie_details.json?movie_id=" . $_GET["yts_id"]);
    $result = json_decode($result_raw, true);
    $id = str_replace("tt", "", $result["data"]["movie"]["imdb_code"]);
    echo(imdb_id_check($id));
    
}