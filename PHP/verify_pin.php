<?php

//This function will verify if a pin is valid

function verify_pin($pin, $uid){
    //this authenticates
    //new sql connection
    require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

    /*
    // Create connection
    $con = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    */

    $con= get_connection('requests');

    //create and execute the sql line
    $sql="SELECT *  FROM `new_account_pins` WHERE `used` = '0' AND `pin` = " . $pin;
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        //TODO: add expiration date functionality

        //set pin as used
        $sql_mark_pin = "UPDATE `new_account_pins` SET `used` = '1', `user_id` = '" . $uid . "' WHERE `new_account_pins`.`pin` = " . $pin;
        $con->query($sql_mark_pin);


        //return true
        return 1;
    }
    else{
        //no results
        return 0;
    }
}