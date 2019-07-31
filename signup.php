

<html>
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NW66M9F');</script>
    <!-- End Google Tag Manager -->

    <title>Hadfiled Signup</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
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
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NW66M9F"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->



    <div id="custom-request-div">
        
        <h1 id="main-title">Create An Account</h1>
        <p class="white">This is the portal for the Hadfield media server. If you do not already have an account on Plex 
            (the place where media is streamed) then an account will be automatically created and invited to the server, with the same username
            and password you use here. Accounts are subject to manual approval, so please be patient. Thanks!
        </p>
        <h3 id="error-message"></h3>
        <form method="post" action="/PHP/addnewuser.php" id="create-form">
            <input type="text" name="username" placeholder="Username" required></input>
            <input type="text" name="email" placeholder="Email" required></input>
            <input type="password" class="password-field" name="pass" placeholder="Password" required></input>
            <input type="password" class="password-field" name="repeat-pass" placeholder="Repeat Password" required></input>
            <br/>
            <label class="white" style="font-size:10pt"><input type="checkbox" name="create-plex" value="1" checked="checked">Create a Plex account for me (You will need this to stream media)</label>
            <?php echo('<input type="hidden" name="pin" value="'. $_GET["pin"] .'"></input>');?>
            <p class="white" style="font-size:10pt">By creating an account, you agree to our <a href="/privacy-policy" target="_blank">Privacy Policy</a> 
        and to Plex's <a href="https://www.plex.tv/about/privacy-legal/" target="_blank">Privacy Policy</a></p>
            <input type="submit" id="submit" value="Create">
        </form>
    </div>


    <script src="/JS/errorDisplay.js"></script>

</body>

</html>


