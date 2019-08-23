
<html>
<style>
    body{
        padding-bottom:1000px;
    }
    img{
        max-width:100%;
        vertical-align: middle;
        
    }

    .step{
        max-width:350px;
        min-width:150px;
        display:inline-block;
        margin: 10px;

    }
    @media screen and (max-width: 700px) {
        div#contact-form { display: none }  
    }
    @media screen and (min-width: 700px) {
        div#contact-button { display: none }
        
    }

</style>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">
    
</head>

<body>
    <div>
        <h1 class="white">Help Page</h1>
    </div>
    <div class="item rounded">
        <h2>What do you need help with?</h2>
        <button class="watch_button" onclick="window.location.href = '/howto.php#plex-first-login';">No Movies Appear in Plex</button>
        <button class="watch_button" onclick="window.location.href = '/howto.php#not-approved';">Login "Not Approved"</button>
        <button class="watch_button" onclick="window.location.href = '/howto.php#contact-webmaster';">Page is frozen or blank</button>
        <button class="watch_button" onclick="window.location.href = '/howto.php#invite';">Invite Friend</button>
        <button class="watch_button" onclick="window.location.href = '/howto.php#contact-webmaster';">Other</button>
    </div>

    <div id="plex-first-login" class="item rounded">
      <h2>First Login to Plex</h2>
      <p>If this is your first login to plex, you must accept an invitation from 'harrismcc'. This will
      allow you to view all available media. This step needs to be done the first time you login.</p>
      
    <div class="step">
        <h3>1.</h3>
        <img src="https://i.imgur.com/JzpzFNf.png">
    </div>

    <div class="step">
        <h3>2.</h3>
        <img src="https://i.imgur.com/jUi3nle.png">
    </div>

      <div class="step">
        <h3>3.</h3>
        <img src="https://i.imgur.com/5zeUCrB.png">
      </div>

    </div>

    <div class="item rounded" id="not-approved">
        <h2>Login Not Approved</h2>
        <p>If you try to login and you can't because your account is not approved, this means the admins are still
        reviewing your account. This community is closed, meaning that all accounts are subject to manual approval.
        If you think this is an error, contact the webmaster</p>
        <button class="watch_button" onclick="window.location.href = '/howto.php#contact-webmaster';">Contact Webmaster</button>
    </div>

    <div class="item rounded" id="invite">
        <h2>Invite Friend</h2>
        <p>Hadfield Media is a closed community, meaning that you have to be invited by a current user or by an admin in order to join.
         Each current user is able to create 3 invite codes. Please note that codes you make that are unused still count towards those 3 (so use them carefully!). </p>
        
    </div>

    <div class="item rounded" id="contact-webmaster">
        <h2>Contact Webmaster</h2>
        <p>If you are having trouble that can't be fixed with help from this page, please contact the webmaster</p>
        <div id="contact-form">
            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSciJ9X7UVx0-ai6gfSDxjS5u2Jt-Z5qoNatDumJV43a4InpTA/viewform?embedded=true" width="640" height="948" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
        </div>
        <div id="contact-button">
            <button class="watch_button" onclick="window.location.href = 'https://forms.gle/9YxmZxEyfVvysKqL8';">Contact</button>
        </div>
    </div>
</body>

</html>


