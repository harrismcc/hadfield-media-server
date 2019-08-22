<?php
require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

//start user session
session_start();

/*
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} */

$conn= get_connection('requests');

//Test if movie is already in the requests db
$sql_imdb_test = "SELECT * FROM `requests_table` WHERE `imdb_id` = '" . $_GET["imdb_id"] . "'";
$result = $conn->query($sql_imdb_test);

while($row = $result->fetch_assoc()){
	//go through all results
	//echo("Thanks " . $_SESSION["username"] . ", looks like this item is already in the database. (Can't find it? Contact a site admin)");
	echo("Looks like someone has already submitted a request for this title. Come back later and it will be ready!");
	die();
}




$sql = "INSERT INTO requests_table (`user`, `type`, `name`, `imdb_id`,`yts_id`, `comments`, `torrent_url`, `magnet`, `poster_url`) VALUES (?,?,?,?,?,?,?,?,?)";
//echo($sql);
$stmt = $conn->prepare($sql);
//replaced $_GET["user"] with 
$stmt->bind_param("sssssssss",$_SESSION["username"], $_GET["type"], $_GET["name"], $_GET["imdb_id"], $_GET["yts_id"], $_GET["comments"], $_GET["torrent_url"], $_GET["magnet"], $_GET["movie_poster"]);



if ($stmt) {
	$stmt->execute();
	echo("Thanks " . $_SESSION["username"] . ", your request was submitted!");
}

die();
?>
