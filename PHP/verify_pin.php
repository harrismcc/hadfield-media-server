<?php
require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

//This function will verify if a pin is valid
if (isset($_GET["pin"])){
    echo(verify_pin($_GET["pin"], "test"));
}

function verify_pin($pin, $uid){
    //this authenticates
    //new sql connection


    $con= get_connection('requests');

    //create and execute the sql line
    $sql="SELECT *  FROM `new_account_pins` WHERE `used` = '0' AND `pin` = " . $pin;
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            $now = time(); // or your date as well
            $your_date = strtotime($row["created"]);
            $datediff = $now - $your_date;

            $age = $datediff / (60 * 60 * 24);

            //Expiration date of 30 days
            if ($age > 30){
                return 0;
            }
            
        }

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

function create_new_pin(){
    $con= get_connection('requests');

    $pin = strval(rand(10000, 999999999));
    

    $sql="INSERT INTO `new_account_pins` (`pin`, `used`) VALUES ('" . $pin . "', '0')";
    $result = $con->query($sql);

    return $pin;
}