var script = document.createElement('script');
script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js' 
script.src = '/JS/scrollTo/jquery.scrollTo.js'
document.getElementsByTagName('head')[0].appendChild(script); 



//first thing to do is hide results and display
$("#results-div").hide();
$("#display-div").hide();


//load only if html is ready
$(document).ready(function(){
    

    function createTable(query){
      //get json from api
      //https://yts.lt/api/v2/list_movies.json?query_term=the+martian
      //and assemble a table

      //console.log(query);
      $.ajax({
        url: 'https://yts.lt/api/v2/list_movies.json',
        type: "GET",
        data: {query_term : query},
        dataType: "html",
        success: function (data) {
          
          var obj = JSON.parse(data);
          
          //console.log(obj);
          $("#recs-box").hide();

          
          //create table
          var tbl=$("<table/>").attr("id","results-table");
          $("#results-div").append(tbl);
          var movies = obj["data"]["movies"]
          if (movies){
            for(var i=0;i<movies.length;i++)
            {
                //console.log(movies[i]["id"]);
                
                var tr="<tr>";
                var td1="<td>\
                <a href="+ "https://www.youtube.com/watch?v=" +movies[i]["yt_trailer_code"] +" target='_blank'>\
                <img class='icon'src="+movies[i]["medium_cover_image"] + ">\
                </a>\
                </td>";
                var td2="<td><p>"+movies[i]["title"]+"</p></td>";
                var radio='<td><button class="expand_button" movie_id=' + movies[i]["id"] + '>More</button></td>';
                
        
              $("#results-table").prepend(tr+td1+td2+radio); 
              //console.log("done");
    
            } 

            //create first row
            var tr="<tr>";
            var td1="<th><h3>Image</h3></th>";
            var td2="<th><h3>Title</h3></th>";
            var td3="<th><h3>Select</h3></th>";
            $("#results-table").prepend("<tr>"+td1+td2+td3+"</tr>");
          } else {
            $("#results-div").append("<h2>No Results</h2>");
          }

          //alert($("button").html());
          $( ".expand_button" ).on( "click", function(){
            //alert($(this).attr("movie_id"));
            fill_display($(this).attr("movie_id"));
            
          });

        }
       

        });


    }
    
    $("#search-form").submit(function(){
      //when search query submitted

      $("#display-div").empty()//clear any displaying title
      $("#results-table").remove();//clear results of last search
      $("#results-div").empty();
      $("#results-div").show();
      $("#display-div").hide(); //hide old display div
      

      createTable($("#search-input").val());
      
      //prevent default form submit action
      event.preventDefault();
      
      });


    
    function fill_display(movieId){
      //take in a movieId and use that to populate the display div
      $.ajax({
        url: 'https://yts.lt/api/v2/movie_details.json',
        type: "GET",
        data: {movie_id : movieId, with_cast: true},
        dataType: "html",
        success: function (data) {
          

          var data = JSON.parse(data);
          //console.log(data);
          var data = data["data"]["movie"];//navigate to correct part of json

          
          $("#display-div").empty();

          var reversed = data["torrents"].length - 1;//length-1 b/c it always returns the highest res last
          
         

          var movie_data = $.get(window.location.origin + "/api/v1/get-movie.php?yts_id=" + movieId, function(data){
            
            try{
              
              //create custom watch button
              $("#display-div").append("<button id='custom-watch' class='send_request_button' exists='true' movie_name=" + $.parseJSON(data)["data"]["name"] + ">Watch This Movie!</button>");
              $("#request_button").hide(); //hide request button because it is already in db

             //watch button listner
            $("#custom-watch").on("click", function(){
              window.location.href = "http://hadfield.webhop.me:32400/web/index.html#!/server/39125569d7281c7ec7a57d94afa124027af31557/search/" + $("#custom-watch").attr("movie_name");
            
            });
            }
            catch(e){
              console.log(e);
              
              
            }
            
          });

          

          //check if "watch" button exists
          if ($(".custom-watch").attr("movie_name") == undefined){
             //if not exists, create request button
              $("#display-div").append("<button id='request_button' class='send_request_button' exists='false' title= " + encodeURI(data["title"]) + " url=" + data["torrents"][reversed]["url"] + " type=MOVIE imdb=" + data["imdb_code"].replace(/\D/g,'') + " >Request</button>");
              
          }

       

          var cast = "";
          for (var j=0; j<data["cast"].length; j++){
            cast += data["cast"][j]["name"] + ", ";
            
          }
          cast = "<p><strong>" + cast + "</strong></p>";
          //create other html elements
          //var image = "<img src=" + data["medium_cover_image"] + ">";
          var image = "";
          var trailer = '<iframe width="90%" height="315" src="https://www.youtube.com/embed/'+ data["yt_trailer_code"] +'"\
           frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
          var title = "<h1>" + data["title"] + "</h1>";
          var desc = "<p>" + data["description_full"] + "</p>";
          $("#display-div").prepend(image + trailer +title + cast + desc);

          //assemble elements in div
          $("#display-div").show();
          $(window).scrollTo($("#display-div"));//scroll to display window

          //send request button listner
          $( ".send_request_button" ).on( "click", function(){
            console.log("send_request_button clicked");
            if ($(".send_request_button").attr("exists") == "false"){
              $.get( "/PHP/insertrequest.php",{user: 'hadfield_request_portal', name : $(this).attr("title"), type : $(this).attr("type"), torrent_url : $(this).attr("url"), imdb_id : $(this).attr("imdb")}, function( data ) {
                
                alert(data);
                
                $(".send_request_button").html("Done");
                $(".send_request_button").css('background', '#E7C272');
                $(".send_request_button").prop("disabled",true);
              });
            } else {
              //movie already exists
              alert("exists");
              
            
            }
          });

          
          
        }

      });



    }


$(".watch_button").click(function(){
  //console.log("Watch Button Cicked");
  if ($(this).attr("firstLogin") == "1"){
    open("http://hadfield.webhop.me/watch/?firstLogin=1");
  }
  else{
    open("http://hadfield.webhop.me/watch/?firstLogin=0")
  }
});

//Hamburger Menu Functionality
$("#back-button").on('click', function() {
  //show menu on click
  $("nav.menu").toggleClass("menu_show");
});


//This section allows user to click "off" the menu to dismiss
$('#back-button').on('click', function(e) {
  e.stopPropagation(); 
});
$('.menu').on('click', function(e) {
  e.stopPropagation();
});

//if anywhere is clicked that does NOT have stopped propigation,
//menu toggles
$(document).on('click','body',function(){
  if (($("nav.menu").attr("class").indexOf("menu_show") >= 0)){
    $("nav.menu").toggleClass("menu_show");
  }
  
});



//fill the recents dispay in an async way
//improves loading time
function fillRecentDisplay(){
  //Create recent movie display
  $("#recs-box").html("<h3>Loading...</h3>");
  $.ajax({
    url: 'http://' + document.location.hostname + '/PHP/sync/get-recent.php',
    type: "GET",
    data: {},
    dataType: "html",
    success: function (data) {

      $("#recs-box").html(data);

        //Make recent posters clickable
      $(".recentPoster").on('click', function(){
        if ($(this).attr("imdb_id")){
          fill_display($(this).attr("imdb_id"));
        }
        
      });


    }
  });
}

//execute recent dispay function
fillRecentDisplay();



});



