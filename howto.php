<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php";
//Auth user
//require_auth(); //"1" level access - no admin needed

if (!isset($_SESSION["username"])){
    header("Location: /login.php");
    exit;
}


//admin only
if ($_SESSION["admin"] == 0){
    header("Location: /login.php");
    exit;
}

?>


<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
</head>

<body>
    <div id="exp-main" class="white">
        <h1 class="white">How To</h1>
        <p>Hello, welcome to the help page for the Hadfield media server project. Outlined below are the steps 
        to using the service. Keep in mind that this is in development and so may be rough around the edges.</p>
        <br/>
        <h3>1. Create Requests Account</h3>
        <p>This website is used to automatically request and download new movies onto the media server.
        In order to use it, you need to create an account. To do so, click <a href="/signup.php">here</a>.</p>
        <br/>
        <h3>2. Request A Movie</h3>
        <p>To request a movie, search for it in the search bar.</p>
        <img src="http://i67.tinypic.com/2iv1734.png" class="howtoimg"></img>
        <p>Click "More"</p>
        <img src="http://i63.tinypic.com/2yllnjc.png" class="howtoimg"></img>
        <p>And then choose the highest quality possible (usually 1080p)</p>
        <img src="http://i67.tinypic.com/2saxbq1.png" class="howtoimg"></img>
        <p>The movie is then added to an database which places it in a que for download, after some period of time the movie will appear in the "Movies" section of plex.</p>
        <br/>
        <h3>3. Create Plex Account</h3>
        <p>You should get an email with a plex invite, like below</p>
        <img src="http://i68.tinypic.com/rcr1ck.png" class="howtoimg"></img>
        <p>Simply accept the invitation and log in <a href="http://plex.tv/">here</a>. Note that if you are having issues, create a plex account first (using the email you used 
        for the requests server), then accept the invitation.</p>

        <br/>
        <h3>4. Use Plex</h3>
        <p></p>
    <div>
</body>

</html>


