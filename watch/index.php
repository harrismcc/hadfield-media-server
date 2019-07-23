<html>
<!--This page redirects to the plex server and serves no other purpose-->
<head>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
        
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NW66M9F');</script>
    <!-- End Google Tag Manager -->

    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">

    <?php
        
        session_start(); //start user session

        include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

        if (!isset($_SESSION["username"])){
            header("Location: /login.php");
            die();
        }


        
        echo("<div id='main-title' class='white'><h1 class='white'>Waking Server...</h1></div>");
        echo("<div class='center'><img class='center' src='/assets/waking.gif' width='60%'></img></div>");
        
        ob_end_flush();
        ob_flush();
        flush();
        ob_start();



        //send WOL packet and log into db
        include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");
        include $_SERVER['DOCUMENT_ROOT']."/PHP/system-commands/wol.php";

       
        if ($_GET["firstLogin"] == 1){

             // Create connection
            $con = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
        
            $sql= "UPDATE `auth_table` SET `plex_logged_in_once` = '1' WHERE `username` = '" . $_SESSION["username"] . "'";
            $result = $con->query($sql);
            echo("<script>alert('Please accept the invite from harrismcc when you login to plex');</script>");
            
            ob_flush(); //flush buffer, aka send output to browser

            header("Location: http://hadfield.webhop.me:32400/web/index.html#!/settings/users/friends");

        }
        else{
            header("Location: http://hadfield.webhop.me:32400");
        }

        

    ?>
    <script>
    //http://hadfield.webhop.me:32400/web/index.html#!/settings/users/friends
    window.onload = function() {
    window.location = 'http://'+window.location.hostname+':32400'
    }
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135754439-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-135754439-2');
    </script>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NW66M9F"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

</body>
</html>