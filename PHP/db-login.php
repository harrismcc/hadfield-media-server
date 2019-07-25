<?php


function get_connection($dbname){
    $username = getenv('DB_LOGIN_USERNAME');
    $password = getenv('DB_LOGIN_PASSWORD');
    $servername = 'localhost'

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        return 0;
    } else {
        return $conn;
    }


}