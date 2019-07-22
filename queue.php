<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php";
//Auth user
//require_auth(); //"1" level access - no admin needed

if (!isset($_SESSION["username"])){
    header("Location: /login.php");
    exit;
}

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
    

    <script src="/JS/queue.js"></script>
</body>

</html>


