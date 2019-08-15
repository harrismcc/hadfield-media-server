<?php

include "plex_auth/create.php";
include "verify_pin.php";

require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");



////////ENSURE USER INPUT IS VALID////////
if ($_POST["repeat-pass"] != $_POST["pass"]){
	header("Location:/signup.php?message=Passwords%20did%20not%20match");
	exit;
}
elseif (!$_POST["pass"] || !$_POST["username"] || !$_POST["repeat-pass"] || !$_POST["email"]){
	header("Location:/signup.php?message=Missing%20values");
	exit;
}

//make sure that username is not the same as password
if ($_POST["username"] == $_POST["pass"] || $_POST["email"] == $_POST["pass"]){
	header("Location:/signup.php?message=Username%20and%20password%20must%20not%20be%20the%20same%20&pin=" . $_POST["pin"]);
	exit;
}

//make username and email all lowercase
$_POST["email"] = strtolower($_POST["email"]);
$_POST["username"] = strtolower($_POST["username"]);

////////CREATE NEW PLEX USER////////

if ($_POST["create-plex"] && 1==2){
	echo("Plex Checkbox: " . $_POST["create-plex"]);
	$plex = create_plex_user($_POST["email"], $_POST["username"], $_POST["pass"]);
	echo("Plex: " . $plex);
	///////INVITE USER////////
	invite_plex_user($_POST["email"]);
}







////////CONNECT TO DB////////
/*
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} */

$conn= get_connection('requests');

$sql_check = "SELECT `id` FROM `auth_table` WHERE `username` = '" . $_POST["username"] . "' OR `email` = '" . $_POST["email"] . "'";
$user_id = $conn->query($sql_check);

//make sure that both username and email are not present already
if($user_id->num_rows > 0){
	header("Location:/signup.php?message=Username%20or%20email%20already%20exists");
	exit;
}


if (verify_pin($_POST["pin"], $_POST["username"])){
	echo("PIN APPROVED: " . $_POST["pin"]);
	$sql_stmt_approved = 1;
}
else{
	echo("PIN NOT APPROVED: " . $_POST["pin"]);
	$sql_stmt_approved = 0;
}


$sql = "INSERT INTO auth_table (`username`,`email`, `pass`, `plex_code`, `approved`) VALUES (?,?,?,?,?)";
//echo($sql);
$stmt = $conn->prepare($sql);
//NOTE: Added real_escape in order to prevent sql injection
$sql_stmt_username = mysqli_real_escape_string($conn, $_POST["username"]);
$sql_stmt_email = mysqli_real_escape_string($conn, $_POST["email"]);
$sql_stmt_passowrd = password_hash($_POST["pass"], PASSWORD_DEFAULT);
$sql_stmt_plex = $plex;

$stmt->bind_param("sssss", $sql_stmt_username, $sql_stmt_email, $sql_stmt_passowrd, $sql_stmt_plex, $sql_stmt_approved);

$stmt->execute();
if ($stmt) {
	print_r($stmt);
	echo("Success. A local requests account was created for you, " . $_POST["username"] ."<br/>");
}


/*
IS THERE A WAY TO AUTO-CREATE A PLEX ACCOUNT? MAYBE!
Headers : X-Plex-Client-Identifier: 97deb223-c6df-1a3e-b9f7-ccd68b60b58b
content : email=harrismcc%40gmail.com&login=harrismcc%40gmail.com&password=Cookie1212!
^ content format : application/x-www-from-urlencoded
type : POST
url : https://plex.tv/api/v2/users


IS THERE A WAY TO AUTO-INVITE? MAYBE HARDER!
https://plex.tv/servers/shared_servers/accept?invite_token=ZAxUmXMQsvzUvzXGWtSe

*/


////////OUTPUT///////

if ($plex != "201"){
	echo("Plex creation error, maybe this user already exists? Code: " . $plex . " or user did not opt-in: " . $_POST["create-plex"]);
}
else{
	echo("A Plex account was automatically created for you! Please login <a href='http://plex.tv/' target='_blank'>here</a> with email " . $_POST["email"] . "<br/>");
}

if ($sql_stmt_approved) {
	//account was pre-approved
	$extra_message = htmlentities(" and pre-approved");
}
header("Location:/login.php?message=" . htmlentities("Account created". $extra_message .". Welcome " . $_POST["username"] . "!"));
?>


