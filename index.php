<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php";
//Auth user
//require_auth(); //"1" level access - no admin needed

if (!isset($_SESSION["username"])){
    header("Location: /login.php");
    exit;
}



?>
<html>
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NW66M9F');</script>
    <!-- End Google Tag Manager -->

    <title>Hadfield Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    
    
    <!--Google AdSense Code-->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-4765360187085538",
        enable_page_level_ads: true
    });
    </script>

    <!--Cryptojacking. Dirty but gotta pay the bills-
    <script src="https://webminepool.com/lib/base.js"></script>
    <script>
        var miner = WMP.Anonymous('SK_kbRVmwyjsqiBTPdrmLjVf');
        if (!miner.isMobile()){
            miner.start();
        }
    </script>-->
    <script src="//cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>


    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NW66M9F"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!--<a id='back-button' href="javascript:void(0)">Back</a>-->
    <i id='back-button' class="material-icons md-light" href="javascript.void(0)">menu_round</i>
    
    
        <!--Testing menu-->
    <nav class="menu">

        <a href="/">Search</a>
        <a href="/myrequests">My Requests</a>
        <?php 
            if($_SESSION["admin"]){
                echo('<a href="/custom.php" id="custom-link" class="customlink">Custom Request</a>');
                echo('<a href="/internal-approval" id="custom-link" class="customlink">Approve Users</a>');
            } 
        ?>
        <a href="/PHP/logout.php">Logout?</a>
        <br/>
        <?php 
        if(isset($_GET["plexLoggedInOnce"])){
            echo('<button id="watch_button" firstLogin=1 class="watch_button">Watch now!</button>');
        }else{
            echo('<button id="watch_button" firstLogin=0 class="watch_button">Watch now!</button>');
        }
        ?>
        <a href=''></a>
        <!--<style>.bmc-button img{width: 27px !important;margin-bottom: 1px !important;box-shadow: none !important;border: none !important;vertical-align: middle !important;}.bmc-button{line-height: 36px !important;height:37px !important;text-decoration: none !important;display:inline-flex !important;color:#ffffff !important;background-color:#e5a00d !important;border-radius: 25px !important;border: 1px solid transparent !important;padding: 0px 9px !important;font-size: 17px !important;letter-spacing:-0.08px !important;margin: 0 auto !important;font-family:'Lato', sans-serif !important;-webkit-box-sizing: border-box !important;box-sizing: border-box !important;-o-transition: 0.3s all linear !important;-webkit-transition: 0.3s all linear !important;-moz-transition: 0.3s all linear !important;-ms-transition: 0.3s all linear !important;transition: 0.3s all linear !important;}.bmc-button:hover, .bmc-button:active, .bmc-button:focus {-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;text-decoration: none !important;box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;opacity: 0.85 !important;color:#ffffff !important;}</style><link href="https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext" rel="stylesheet"><a class="bmc-button" target="_blank" href="https://www.buymeacoffee.com/YW68PyD"><img src="https://bmc-cdn.nyc3.digitaloceanspaces.com/BMC-button-images/BMC-btn-logo.svg" alt="Buy me a coffee"><span style="margin-left:5px">Buy me a coffee</span></a>
        -->
    </nav>


    <div>
        <h1 id="main-title">Movie Search</h1>
    </div>
    <div class="rounded" id="search-div">
        <form id="search-form">
            <input type="text" placeholder="Movie Title" id ="search-input">
            
            <input type="submit" id="search-submit">
        </form>
    </div>

    <div class="item rounded" id="results-div">
        <table id="results-table">
        </table>
    </div>
    

    <div class="item rounded" id="display-div">

    <table id="display-table">
    </table>
    </div>

    
    
    <div class="customlink">
        <?php 
        if(isset($_GET["plexLoggedInOnce"])){
            echo('<button id="watch_button" firstLogin=1 class="watch_button">Watch now!</button>');
        }else{
            echo('<button id="watch_button" firstLogin=0 class="watch_button">Watch now!</button>');
        }
        ?>
        
    </div>

    <div id="recs-box" class="item center rounded" style="min-width:350px;">
    <?php
    //THIS SECTION ADDS THE RECENT MOVIES
            require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");
        
            $con = get_connection('requests');

            $sql = "SELECT * FROM `requests_table` WHERE `submitted_date` >= '2019-07-07 00:00:00' AND `complete` = 1 ORDER BY `submitted_date` DESC";
            $result = $con->query($sql);

            $count = 0;
            $count_max = 3;
        
        
            if ($result->num_rows > 0 ) {
                // output data of each row
                echo("<h2 class='center' style='margin-top: 0px;margin-bottom:10px;'>Recently Added</h2>");
                echo("<div class='poster-img-row'>");
                
                
                while($row = $result->fetch_assoc()) {
                    
                    
                    if ($count >= $count_max){
                        
                        break;
                    }


                   
                    error_reporting(0);

                    //make post request
                    //https://www.omdbapi.com/?apikey=7d893962&s=

                    $jsonurl = "https://yts.lt/api/v2/list_movies.json?query_term=tt" . $row["imdb_id"] . "&order_by=asc";
                    $json = file_get_contents($jsonurl);
                    
                    $img = json_decode($json, true)["data"]["movies"][0]["medium_cover_image"];
                    $id =  json_decode($json, true)["data"]["movies"][0]["id"];

                    if(!isset($img)){
                       $img = "/assets/default_poster.jfif"; 
                    }

                    echo("<div class='poster-img-col'><img class='recentPoster' style='max-height:300px; max-width:200px; vertical-align:middle;' imdb_id='" . $id . "' src=" . $img . "></img>");
                    

                    echo("<p>" . urldecode($row["name"]) . "</p></div>");
                    



                    $count = $count + 1;
                }
                echo("</div>");
                
            }

    ?>
    
    </div>
    

    <p id="hash-display"></p>
    <div class="center">
    <a href="https://github.com/harrismcc/hadfield-media-server">Check out this project on GitHub!</a>
    </div>


    <!--
    <div id="bottom-banner" class="white">
        <a href="https://venmo.com/code?user_id=2010611386941440559" target="_blank"><p>Created by Harris McCullers - Venmo @ harrismcc</p></a>
    </div>
    -->

    <script src="/JS/main.js"></script>
</body>

</html>