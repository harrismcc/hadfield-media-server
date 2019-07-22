
var script = document.createElement('script');
script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js' 
script.src = '/JS/scrollTo/jquery.scrollTo.js'
document.getElementsByTagName('head')[0].appendChild(script); 


//load only if html is ready
$(document).ready(function(){



    function parseURL(url) {
        var parser = document.createElement('a'),
            searchObject = {},
            queries, split, i;
        // Let the browser do the work
        parser.href = url;
        // Convert query string to object
        queries = parser.search.replace(/^\?/, '').split('&');
        for( i = 0; i < queries.length; i++ ) {
            split = queries[i].split('=');
            searchObject[split[0]] = split[1];
        }
        return {
            protocol: parser.protocol,
            host: parser.host,
            hostname: parser.hostname,
            port: parser.port,
            pathname: parser.pathname,
            search: parser.search,
            searchObject: searchObject,
            hash: parser.hash
        };
    }

    var message = unescape(parseURL(window.location.href)["searchObject"]["message"]);

    if(message != "undefined"){
        $("#error-message").html(message);
    }

});