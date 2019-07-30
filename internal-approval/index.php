<?php
include($_SERVER['DOCUMENT_ROOT'] . "/PHP/auth.php");
include($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");


if (!isset($_SESSION)){session_start();}

//Auth user
if (!isset($_SESSION["username"])){
    header('HTTP/1.0 401 Unauthorized');
    echo("<h1>401 Unauthorized</h1>");
    echo("<p>You don't have access to this page</p>");
    
    //header("Location: /login.php");
    exit;
}

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1){
    echo("<h1>401 Unauthorized</h1>");
    header('HTTP/1.0 401 Unauthorized');
    echo("<p>You don't have access to this page</p>");
    //header("Location: /index.php");
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
            window.location.href = window.location.origin + "/index.php";
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


        //AUTH USER FROM POST REQUEST
        if (isset($_GET["id_to_approve"])){
            //approve id
            $sql = "UPDATE `auth_table` SET `approved` = '1' WHERE `auth_table`.`id` = " . $_GET["id_to_approve"];
            $result = $con->query($sql);
            echo("<div class='center'><h3>Approved ID: " . $_GET["id_to_approve"] . "</h3></div>");
        }



        //DISPLAY USERS SECTION
        $sql="SELECT `id`, `username`, `email`, `date_created` FROM `auth_table` WHERE `approved` != 1";

        $result = $con->query($sql);
    


        if ($result->num_rows > 0) {
            // output data of each row

            echo("<div class='item rounded'>");
            echo("<table id='my-requests-table'>");
            echo("<tbody class='my-results-tbody'>");
            echo("<tr><th><h3>ID</h3></th><th><h3>Name</h3></th><th><h3>Email</h3></th><th><h3>Date</h3></th><th><h3>Approve</h3></th><tr>");
            while($row = $result->fetch_assoc()) {

            
                $id_row = "<td><p>" . $row["id"] . "</p></td>";
                $name_row = "<td><p>" . $row["username"] . "</p></td>";
                $email_row = "<td><p>" . $row["email"] . "</p></td>";
                $date_row = "<td><p>" . $row["date_created"] . "</p></td>";
                $button_row = "<td>" . "<form><input type='hidden' name='id_to_approve' value='" . $row["id"] . "'></input><button type = 'submit' class='expand_button'>Approve</button></form>" . "</td>";

                //output
                print_r("<tr>" . $id_row . $name_row . $email_row . $date_row . $button_row ."</tr>");
                

                
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
        <form action="/internal-approval" method="GET">
            <input type="hidden" name="make-pin" value="1"></input>
            <button type="submit" id="watch-button" firstLogin=1 class="watch_button">Create Pin</button>
        </form>

        <?php
        if (isset($_GET["make-pin"])){
            include($_SERVER['DOCUMENT_ROOT'] . "/PHP/verify_pin.php");
            
            $pin = create_new_pin();
            echo('<div id="pin-div" class="item rounded"><h2>New Pin:</h2><p id="pin-out">http://hadfield.webhop.me/signup.php?pin=' . $pin . '</p></div>');
            $msg = "This is a test message.\nSo just ignore it I guess:\n" . $pin;
            //mail("harrismcc@gmail.com","My subject",$msg);

        }
        ?>
        
        
    </div>
    
    
</body>

</html>