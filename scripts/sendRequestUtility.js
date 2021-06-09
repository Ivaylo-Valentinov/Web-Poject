function sendRequest(url, options, successCallback, errorCallback) { 
    console.log("Sending request");

    
    var request = new XMLHttpRequest();
    console.log("Before if", request.responseText);

    request.addEventListener('load', function() { 
        console.log(request.responseText);
        var response = JSON.parse(request.responseText);
        

        if (request.status === 200) {
            successCallback(response);
        } else {
            errorCallback(response);
        }
    });

    request.open(options.method, url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(options.data);
     
    
}