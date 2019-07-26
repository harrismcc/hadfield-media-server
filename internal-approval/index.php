<?php
include($_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php");
include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");


if (!isset($_SESSION)){session_start();}

//Auth user
if (!isset($_SESSION["username"])){
    header("Location: /login.php");
    exit;
}

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1){
    header("Location: /index.php");
    exit;
}

?>
<html>
<head>
    <title>My Requests</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery.scrollto@2.1.2/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/StyleSheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1.0, user-scalable=no">
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NW66M9F');</script>
    <!-- End Google Tag Manager -->

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NW66M9F"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <i id='back-button' class="material-icons md-light" href="/index.php">arrow_back_ios</i>
    <script>
        $("#back-button").on('click', function(){
            window.location.href = "http://hadfield.webhop.me/index.php";
        });
    </script>



    <div>
        <h1 id='main-title'>My Requests</h1>
    </div>
    <?php

        /*
        // Create connection
        $con = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }*/
        $con= get_connection('requests');

        //create and execute the sql line
        //only get lines where a link exists
        //TODO: add support for lines with magnet links
        $sql="SELECT `id`, `username`, `email` FROM `auth_table` WHERE `approved` != 1";

        $result = $con->query($sql);
    


        if ($result->num_rows > 0) {
            // output data of each row

            echo("<div class='item rounded'>");
            echo("<table id='my-requests-table'>");
            echo("<tbody class='my-results-tbody'>");
            echo("<tr><th><h3>ID</h3></th><th><h3>Name</h3></th><th><h3>Email</h3></th><th><h3>Approve</h3></th><tr>");
            while($row = $result->fetch_assoc()) {

            
                $id_row = "<td><p>" . $row["id"] . "</p></td>";
                $name_row = "<td><p>" . $row["username"] . "</p></td>";
                $email_row = "<td><p>" . $row["email"] . "</p></td>";

                //output
                print_r("<tr>" . $id_row . $name_row . $email_row . "</tr>");
                

                
            }
            echo("<tbody>");
            echo("</table>");
            echo("</div>");
        }
        else{
            echo("<div class='item rounded'>");
            echo("<h2>None found</h2>");
            echo("</div>");
        }
        $con->close();  


    ?>

    <div class="customlink">
    <button id="watch-button" onclick="location.href = '/watch';" firstLogin=1 class="watch_button">Watch now!</button>
        
    </div>
    
</body>

</html>