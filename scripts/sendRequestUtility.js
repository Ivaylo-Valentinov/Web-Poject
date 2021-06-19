function sendRequest(url, options, successCallback, errorCallback) {
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

function sendMultipartDataRequest(url, options, successCallback, errorCallback) {
    var request = new XMLHttpRequest();
    request.open(options.method, url, true);
    request.send(options.formdata);
    request.addEventListener('load', function() {
        console.log(request.responseText);
        var response = JSON.parse(request.responseText);
        
        if (request.status === 200) {
            successCallback(response);
        } else {
            errorCallback(response);
        }
    });
}