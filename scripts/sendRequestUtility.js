function sendRequest(url, options, successCallback, errorCallback) {
    var request = new XMLHttpRequest();
    //console.log("Request");
    //console.log(request);

    request.addEventListener('load', function() { 
        //console.log("response text:");
        //console.log(request.responseText);
        var response = JSON.parse(request.responseText);
       
        if (request.status === 200) {
            //console.log("Calling success callback");
            //console.log(response);
            successCallback(response);
        } else {
            errorCallback(response);
        }
    });

    request.open(options.method, url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(options.data);
}