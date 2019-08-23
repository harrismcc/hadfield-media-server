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

    <div class="item rounded">
    <h1>Invites</h1>
    <p>The Hadfield media project is a closed community, meaning that users must be invited or approved
    by and admin to join. Each user is able to invite 3 other users.</p>
    <?php
    if (!isset($_GET["make-pin"])){
    
        $conn= get_connection('requests');
        //Test if movie is already in the requests db
        $sql = "SELECT `invites_used` FROM `auth_table` WHERE `id` = '" . $_SESSION["user_id"] . "'";
        
        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()) {
            
            echo("<h3>You have used " . $row["invites_used"] . "/3 invites</h3>");
            
            if($row["invites_used"] == "3"){
                
            }
            else{
                echo('<div class="customlink">
                <form action="/invite" method="GET">
                    <input type="hidden" name="make-pin" value="1"></input>
                    <button type="submit" id="watch-button" firstLogin=1 class="watch_button">Create Invite Code</button>
                </form>
                ');
            }
        }
    }

    ?>
    
    </div>

    
        <?php
        if (isset($_GET["make-pin"])){
            include($_SERVER['DOCUMENT_ROOT'] . "/PHP/verify_pin.php");
            
            

           

            //make new pin
            $pin = create_new_pin($_SESSION["user_id"]);



            if($pin != false){
                 //set user pin count
                $conn= get_connection('requests');
                $sql_update = "UPDATE `auth_table` SET `invites_used` = `invites_used` + 1 WHERE `auth_table`.`id` = '" . $_SESSION["user_id"] . "'";
                $result = $conn->query($sql_update);

                echo('<div id="pin-div" class="item rounded"><h2>New Pin:</h2><p id="pin-out">http://hadfield.webhop.me/signup.php?pin=' . $pin . '</p><p>Send this link to the person you want to invite. It can only be used once.</p></div>');
            }
            else{
                //no more invites message
                echo('<div id="pin-div" class="item rounded"><h3>Sorry, looks like you have no more invites!</h3></div>');
            }

        }
        ?>
        
        
    </div>
    
    
</body>

</html>