var script = document.createElement('script');
script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js' 
document.getElementsByTagName('head')[0].appendChild(script); 


//load only if html is ready
$(document).ready(function(){

    $("#custom-form").submit(function(){
        //when search query submitted
        $("#invalid").hide();
        
        

        if (!$("#name").val() || !$("#link").val()){
            console.log("empty");
            $("#custom-request-div").prepend("<h3 id='invalid'>Invalid Submission</h3>");
        }
        else {
            var request = {user: 'hadfield_request_portal_custom', type : "CUSTOM" ,imdb_id : $("#imdb").val().replace(/\D/g,'') , name : $("#name").val(), torrent_url : $("#link").val() };

            if ($("#link").val().substring(0,6) == "magnet") {
                var request = {user: 'hadfield_request_portal_custom', type : "CUSTOM" ,imdb_id : $("#imdb").val().replace(/\D/g,'') , name : $("#name").val(), magnet : $("#link").val() };
            }

            $("#invalid").show();
            $.get( "/PHP/insertrequest.php", request , function() {
            //prevent default form submit action
            
            alert("Sent");
            console.log("sent");
            
            
            })
        }
        event.preventDefault();
    });


});