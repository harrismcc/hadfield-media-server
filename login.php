<html>
<head>
    <title>Hadfield Login</title>
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135754439-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-135754439-2');
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">
</head>

<body>
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
    <a href="/signup.php">Need to create an account?</a>
    
    


    <script src="/JS/errorDisplay.js"></script>
</body>

</html>


