
<?php

include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");


header('Content-Type: application/xml');

//this function formats the title and links into the correct rss format
function createItem($ci_title, $ci_link){
        $ci_title = "<title>" . $ci_title . "</title>";
        $ci_link = "<link>" . $ci_link . "</link>";
        return "<item>" . $ci_title . $ci_link . "</item>";

}

/*
// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}*/

$conn= get_connection('requests');

//create and execute the sql line
//only get lines where a link exists
//TODO: add support for lines with magnet links
$sql="SELECT *  FROM `requests_table` WHERE (`torrent_url` IS NOT NULL OR `magnet` IS NOT NULL) AND `complete` = 0";
$result = $con->query($sql);

//create xml string for all the items using the results of the sql query
$items = "";
while ($row = $result->fetch_assoc()) {
    if ($row["magnet"]){
        //prefer magnet link if there is one
        $items .= createItem(str_replace("%20"," ",$row["name"]), htmlspecialchars($row["magnet"]), ENT_QUOTES);
    } else {
        $items .= createItem(str_replace("%20"," ",$row["name"]), $row["torrent_url"]);
    }
	
}

//init the rss feed with header info
$rss = "<rss version='2.0'><channel>
<title>Hadfield Request feed</title>
<link>hadfield.webhop.me/</link>
<description>This is the XML endpoint for the hadfield server request service.
It creates an xml rss feed on request with all of the items in the request database
that have links associated with them. It ignores items with no links to prevent clutter.
</description>";


//add list of items we created earlier
$rss .= $items;

//finish out the body of the rss with the correct items
$rss .= "</channel></rss>";

//kill the program and return the xml rss feed
die($rss);
