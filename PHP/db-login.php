<?php


function get_connection($dbname){

    $ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/creds.ini", true);

    $username = $ini_array["db_general"]["user"];
    $password = $ini_array["db_general"]["password"];
    $servername = $ini_array["db_general"]["server"];

    if (!(isset($username) && isset($password))){
        error_log("##### ERROR: db login creds not set. Have you configured creds.ini?");
    }


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        error_log('######################' . $conn->connect_error . '######################');
        header("HTTP/1.1 500 Internal Server Error");
    } else {
        return $conn;
    }


}