function sendRequest(url, options, successCallback, errorCallback) {
    console.log("caling send req");
    var request = new XMLHttpRequest();
    
    request.addEventListener('load', function() { 
        
        try {
            var response = JSON.parse(request.responseText);    
            console.log("Request text:", request.responseText);
        } catch (error) {
            console.log("Request text:", request.responseText);
            console.log("Error", error);
        }
               
        if (request.status === 200) {
            console.log("Calling success callback");
            console.log(response);
            successCallback(response);
        } else {
            console.log("Calling error callback");
            console.log(response);
            errorCallback(response);
        }
    });

    request.open(options.method, url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(options.data);
}