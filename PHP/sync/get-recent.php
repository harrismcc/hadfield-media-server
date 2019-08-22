<?php

//TODO: make this not terrible. Use JSON instead of spitting out raw HTML you lazy fuck

            require_once($_SERVER['DOCUMENT_ROOT']."/PHP/db-login.php");

        
            $con = get_connection('requests');

            $count = 0;
            $count_max = 10;


            $sql = "SELECT * FROM `requests_table` WHERE `submitted_date` >= '2019-07-07 00:00:00' AND `complete` = 1 ORDER BY `submitted_date` DESC LIMIT " . $count_max;
            $result = $con->query($sql);

            

            $returnString = "";
        
        
            if ($result->num_rows > 0 ) {
                // output data of each row
                $returnString = $returnString .  "<h2 class='center' style='margin-top: 0px;margin-bottom:10px;'>Recently Added</h2>";
                $returnString = $returnString .  "<div class='poster-img-row'>";
                
                
                while($row = $result->fetch_assoc()) {
                    
                    
                    if ($count >= $count_max){
                        
                        break;
                    }


                   
                    error_reporting(0);

                    //NOTE: Removed this, why call for the image every time when I can just store the url once?
                    //make post request
                    //https://www.omdbapi.com/?apikey=7d893962&s=
                    //$jsonurl = "https://yts.lt/api/v2/list_movies.json?query_term=tt" . $row["imdb_id"] . "&order_by=asc";
                    //$json = file_get_contents($jsonurl);
                    //$img = json_decode($json, true)["data"]["movies"][0]["medium_cover_image"];
                    //$id =  json_decode($json, true)["data"]["movies"][0]["id"];

                    $img = $row["poster_url"];
                    $id = $row["imdb_id"];
                    $yts_id = $row["yts_id"];

                    if(!isset($img) || $row["poster_url"] == ""){
                       $img = "/assets/default_poster_jpeg.webp"; 
                    }

                    $returnString = $returnString .  "<div class='poster-img-col'><img class='recentPoster' style='max-height:300px; max-width:200px; vertical-align:middle;' yts_id= ". $yts_id ." imdb_id='" . $id . "' src=" . $img . "></img>";
                    

                    $returnString = $returnString .  "<p>" . urldecode($row["name"]) . "</p></div>";
                    



                    $count = $count + 1;
                }
                $returnString = $returnString .  "</div>";
                
            }


            die($returnString);
    

?>