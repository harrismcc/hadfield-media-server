<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php";
//Auth user
if (!isset($_SESSION["username"])){
    header("Location: /login.php");
    exit;
}

?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">
</head>

<body>
    <i id='back-button' class="material-icons md-light" href="/index.php">arrow_back_ios</i>
    <script>
        $("#back-button").on('click', function(){
            window.location.href = "http://hadfield.webhop.me/index.php";
        });
    </script>
    <div id="custom-request-div">
        <h1 id="main-title">Custom Request</h1>
        <form id="custom-form">
            <input type="text" id="name" placeholder="Name"></input>
            <input type="text" id="link" placeholder="Link"></input>
            <input type="text" id="imdb" placeholder="IMDB id"></input>
            <input type="submit" id="submit">
        </form>
    </div>


    <script src="/JS/custom.js"></script>
</body>

</html>