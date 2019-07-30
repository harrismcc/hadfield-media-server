<?php


//TODO: we need some way here to check if first login has happened. If not, then invite plex user
include "plex_auth/create.php";


//start user session
if(!isset($_SESSION)){session_start();}

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function checkdb($u, $p) {
    //this authenticates
    //new sql connection
    require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

    /*
    // Create connection
    $con = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }*/

    $con = get_connection('requests');

    //create and execute the sql line
    //only get lines where a link exists
    //TODO: add support for lines with magnet links
    $sql="SELECT *  FROM `auth_table` WHERE `username` = '" . $u . "' OR `email` = '" . $u . "'";
    $result = $con->query($sql);

    $message = "";

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $db_admin_temp = $row["admin"];
            if(($row["username"] == $u || $row["email"] == $u) && password_verify($p, $row["pass"]) && $row["approved"] == 1){
                $auth = 1;
                
            }
            elseif($row["approved"] == 0){
                $auth = 0;
                $message = "Not%20approved";
            }
            else{
                $auth = 0;
                $message = "Incorrect%20login";
            }
            $lstatus = $row["plex_logged_in_once"];
            $email_result = $row["email"];
            $user_result = $row["username"];
        }

    } else {
        $auth = 0;
        $message = "User%20does%20not%20exist";
    }
    $con->close();
    return array('auth' => $auth, 'admin' => $db_admin_temp, 'message' => $message, 'first_login_status' => $lstatus, 'email' => $email_result, 'username' => $user_result);
    
}


function require_auth() {
    header('Cache-Control: no-cache, must-revalidate, max-age=0');

    

    $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
    
    if($has_supplied_credentials){
        $user = $_SERVER['PHP_AUTH_USER'];
        $pass = $_SERVER['PHP_AUTH_PW'];
    } else {
        $user = $_POST["username"];
        $pass = $_POST["password"];
    }


    //Location verification
    $location_data = json_decode(file_get_contents("http://api.ipstack.com/" . getUserIpAddr() . "?access_key=4744960212f44fe7d0e71ed846f6106e"));
    if ($location_data->country_code != "US" && isset($location_data->country_code)){
        echo("http://api.ipstack.com/" . getUserIpAddr() . "?access_key=4744960212f44fe7d0e71ed846f6106e");
        var_dump($location_data);
        die("Region not allowed: " . $location_data->country_code);
    }
    

    $authresults = checkdb($user, $pass);



    
	if (!$authresults["auth"]) {
		//header('HTTP/1.1 401 Authorization Required');
        //header('WWW-Authenticate: Basic realm="Access denied"');
        echo("line 68");
        $location = "Location:/login.php?message=" . $authresults["message"];
        header($location);
		exit;
    }
    else {
        //successful login
        
        $_SESSION["username"] = $authresults["username"];
        $_SESSION["admin"] = $authresults["admin"];

        if (!$authresults["first_login_status"]){
            //add new plex user
            $plex = create_plex_user($authresults["email"], $_SESSION["username"], $_POST["password"]);

            ///////INVITE USER////////
            invite_plex_user($authresults["email"]);

            //set first logged in flag
            $flag_con = get_connection("requests");
        
            //update DB with plex code and logged_in_once flag
            $sql= "UPDATE `auth_table` SET `plex_logged_in_once` = '1', `plex_code` = '" . $plex . "' WHERE `username` = '" . $_SESSION["username"] . "'";
            echo($sql);
            $result = $flag_con->query($sql);


            //header("Location:/index.php?plexLoggedInOnce=0". $result);
        }
        else{
            
            header("Location:/index.php");
        }
        

        
    }
}


if ($_POST) {
    require_auth();
}


?>