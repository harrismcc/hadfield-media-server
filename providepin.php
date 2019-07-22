<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
</head>

<body>
    <div id="custom-request-div">
        <h1 id="main-title">Enter PIN</h1>
        <p class="white">To create an account, you should have been provided a PIN, Please enter it here.
        </p>
        <h3 id="error-message"></h3>
        <form method="post" action="/signup.php" id="create-form">
            <input type="text" name="pin" placeholder="PIN" required></input>
            <input type="submit" id="submit">
        </form>
    </div>
    
    


    <script src="/JS/errorDisplay.js"></script>
</body>

</html>


