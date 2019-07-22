<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
</head>

<body>
    <div id="custom-request-div">
        <h1 id="main-title">Create A Plex Account</h1>
        <p class="white">Use this page to create a new plex account!
        </p>
        <form method="post" action="/PHP/plex_auth/create.php" id="create-form">
            <input type="text" name="username" placeholder="Username" required></input>
            <input type="text" name="email" placeholder="Email" required></input>
            <input type="password" class="password-field" name="pass" placeholder="Password" required></input>
            <input type="password" class="password-field" name="repeat-pass" placeholder="Repeat Password" required></input>
            <input type="submit" id="submit">
        </form>
    </div>


    <!--<script src="/JS/custom.js"></script>-->
</body>

</html>


