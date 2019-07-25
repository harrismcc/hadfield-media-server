<html>
<head>
    <title>Staging - Hadfield Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
    <!--Google AdSense Code-->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-4765360187085538",
        enable_page_level_ads: true
    });
    </script>
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NW66M9F');</script>
    <!-- End Google Tag Manager -->

    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NW66M9F"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <div id="custom-request-div">
        
        <h1 id="main-title">Log In</h1>
        <p class="white">This is the portal for the Hadfield media server
        </p>
        <h3 id="error-message"></h3>
        <form method="post" action="/PHP/auth.php" id="create-form">
            <input type="text" name="username" placeholder="Username" required></input>
            <input type="password" class="password-field" name="password" placeholder="Password" required></input>
            
            <input type="submit" id="submit">
        </form>
    </div>
    
    
    
    <div class="center">
        <a href="/signup.php">Need to create an account? - </a>
        <a href="https://github.com/harrismcc/hadfield-media-server">Check out this project on GitHub!</a>
    </div>

    <script src="/JS/errorDisplay.js"></script>
</body>

</html>


