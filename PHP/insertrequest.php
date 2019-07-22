<?php
include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

//start user session
session_start();


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Test if movie is already in the requests db
$sql_imdb_test = "SELECT * FROM `requests_table` WHERE `imdb_id` = '" . $_GET["imdb_id"] . "'";
$result = $conn->query($sql_imdb_test);

if ($result->num_rows > 0) {
	echo("Thanks " . $_SESSION["username"] . ", looks like this item is already in the database. (Can't find it? Contact a site admin)");
	die();
}



$sql = "INSERT INTO requests_table (`user`, `type`, `name`, `imdb_id`, `comments`, `torrent_url`, `magnet`) VALUES (?,?,?,?,?,?,?)";
//echo($sql);
$stmt = $conn->prepare($sql);
//replaced $_GET["user"] with 
$stmt->bind_param("sssssss",$_SESSION["username"], $_GET["type"], $_GET["name"], $_GET["imdb_id"], $_GET["comments"], $_GET["torrent_url"], $_GET["magnet"]);

if ($stmt) {
	$stmt->execute();
	echo("Thanks " . $_SESSION["username"] . ", your request was submitted!");
}

die();
?>
