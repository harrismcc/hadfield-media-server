<?php

require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");



$err = 1;

while ($err != 0 ){

    /*
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } */

    $conn= get_connection('requests');

    $val = rand(100000000,999999999);
    //$val = "144002622";

    $sql = "INSERT INTO new_account_pins (`pin`, `created`) VALUES ('" . $val . "', '" . date('Y-m-d H:i:s') . "')";
    //echo($sql);
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    if ($stmt->errno == 0) {
        header("Location: http://hadfield.webhop.me/signup.php?pin=" . $val);
        
    }
    $err = $stmt->errno;
}

?>