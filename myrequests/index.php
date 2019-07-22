<?php
include($_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php");
include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");


session_start();

//Auth user
if (!isset($_SESSION["username"])){
    header("Location: /login.php");
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

        /////UPDATE IMDB AND COMPLETED FOR ALL USERS////
        $ch = curl_init();
        $url = 'http://hadfield.webhop.me/PHP/sync/add-imdb.php';
        file_get_contents($url);
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        //set the url, number of POST vars, POST data
        curl_setopt($ch,(CURLOPT_URL), $url);
        curl_exec($ch);

        $url = 'http://hadfield.webhop.me/PHP/sync/update-completed.php';
        file_get_contents($url);

        //set the url, number of POST vars, POST data
        curl_setopt($ch,(CURLOPT_URL), $url);
        curl_exec($ch);
        /////////////////////////////////////

        // Create connection
        $con = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        //create and execute the sql line
        //only get lines where a link exists
        //TODO: add support for lines with magnet links
        $sql="SELECT *  FROM `requests_table` WHERE `user`='" . $_SESSION["username"] . "'";

        if ($_SESSION["admin"] == 1){
            $sql="SELECT *  FROM `requests_table`";
        }

        $result = $con->query($sql);
    


        if ($result->num_rows > 0) {
            // output data of each row

            echo("<div class='item rounded'>");
            echo("<table id='my-requests-table'>");
            echo("<tbody class='my-results-tbody'>");
            echo("<tr><th><h3>Name</h3></th><th><h3>Done</h3></th><th><h3>Date</h3></th><tr>");
            while($row = $result->fetch_assoc()) {

                if ($row["complete"] == 1){
                    $complete_val = "<span class='status-green'></span>";
                }else{
                    $complete_val = "<span class='status-red'></span>";
                }

                $name_row = "<td><p>" . urldecode($row["name"]) . "</p></td>";
                $completed_row = "<td>" . $complete_val . "</td>";
                $date_row = "<td><p>" . $row["submitted_date"] . "</p></td>";

                if ($_SESSION["admin"]){
                    $admin_row = "<td><p>" . $row["user"] . "</p></td>";
                    print_r("<tr>" . $name_row . $completed_row . $date_row . $admin_row . "</tr>");
                } 
                else {
                    print_r("<tr>" . $name_row . $completed_row . $date_row . "</tr>");
                }

                
            }
            echo("<tbody>");
            echo("</table>");
            echo("</div>");
        }
        else{
            echo("<div class='item rounded'>");
            echo("<h2>None found</h2>");
            echo("<p>Go to the search page and make some requests!</p>");
            echo("</div>");
        }
        $con->close();  
    ?>

    <div class="customlink">
    <button id="watch-button" oncli" firstLogin=1 class="watch_button">Watch now!</button>
        
    </div>
    
</body>

</html>