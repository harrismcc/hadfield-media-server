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

      console.log(query);
      $.ajax({
        url: 'https://yts.lt/api/v2/list_movies.json',
        type: "GET",
        data: {query_term : query},
        dataType: "html",
        success: function (data) {
          
          var obj = JSON.parse(data);
          
          console.log(obj);

          
          //create table
          var tbl=$("<table/>").attr("id","results-table");
          $("#results-div").append(tbl);
          var movies = obj["data"]["movies"]
          if (movies){
            for(var i=0;i<movies.length;i++)
            {
                console.log(movies[i]["id"]);
                
                var tr="<tr>";
                var td1="<td>\
                <a href="+ "https://www.youtube.com/watch?v=" +movies[i]["yt_trailer_code"] +" target='_blank'>\
                <img class='icon' src="+movies[i]["medium_cover_image"] + ">\
                </a>\
                </td>";
                var td2="<td><p>"+movies[i]["title"]+"</p></td>";
                var radio='<td><button class="expand_button" movie_id=' + movies[i]["id"] + '>More</button></td>';
                
        
              $("#results-table").prepend(tr+td1+td2+radio); 
              console.log("done");
    
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
          console.log(data);
          data = data["data"]["movie"];//navigate to correct part of json

          
          $("#display-div").empty();

          //create request button (instead of old requests table)
          var test = data["torrents"].length - 1;//length-1 b/c it always returns the highest res last
          
          $("#display-div").append("<button class='send_request_button' title= " + encodeURI(data["title"]) + " url=" + data["torrents"][test]["url"] + " type=MOVIE imdb=" + data["imdb_code"].replace(/\D/g,'') + " >Request</button>");


          /*
          //Removed this functionality that allowed user to pick resolution, because I always want 1080p baby
          var tbl2=$("<table/>").attr("id","display-table");
          $("#display-div").append(tbl2);
          for(var j=0;j<data["torrents"].length;j++)
          {
            
            var std1="<td>"+data["torrents"][j]["size"]+"</td>";
            var std2="<td>"+data["torrents"][j]["quality"]+"</td>";
            var std3="<td>"+data["torrents"][j]["seeds"]+"</td>";
            var std4="<td><a href="+data["torrents"][j]["url"]+">Magnet</a></td>";
            var std5 = "<td><button class='send_request_button' title= " + encodeURI(data["title"]) + " url=" + data["torrents"][j]["url"] + " type=MOVIE imdb=" + data["imdb_code"].replace(/\D/g,'') + " >Request</button></td>";
            console.log(data["title"]);
            $("#display-table").prepend("<tr>"+std1+std2+std3+std4+std5+"</tr>");
            //subtable+= "<tr>"+std1+std2+std3+"</tr>";
          }
          $("#display-table").prepend("<tr><th>Size</th><th>Quality</th><th>Seeds</th><th>Link</th><th>Request</th></tr>");
          */



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

          //button listner
          $( ".send_request_button" ).on( "click", function(){
            //alert($(this).attr("movie_id"));
            $.get( "/PHP/insertrequest.php",{user: 'hadfield_request_portal', name : $(this).attr("title"), type : $(this).attr("type"), torrent_url : $(this).attr("url"), imdb_id : $(this).attr("imdb")}, function( data ) {
              
              alert(data);
              $(".send_request_button").html("Done");
              $(".send_request_button").css('background', '#E7C272');
              $(".send_request_button").prop("disabled",true);
            });
            
          });
          
        }

      });



    }


$(".watch_button").click(function(){
  console.log("Watch Button Cicked");
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


//This section allows user to clock "off" the menu to dismiss
$('#back-button').on('click', function(e) {
  e.stopPropagation(); 
});
$('.menu').on('click', function(e) {
  e.stopPropagation();
});

$(document).on('click','body',function(){
  //if anywhere is clicked that does NOT have stopped propigation,
  //menu toggles

  if (($("nav.menu").attr("class").indexOf("menu_show") >= 0)){
    $("nav.menu").toggleClass("menu_show");
  }
  
});
  

});



