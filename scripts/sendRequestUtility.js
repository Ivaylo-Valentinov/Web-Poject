function sendRequest(url, options, successCallback, errorCallback) {
    var request = new XMLHttpRequest();
    
    request.addEventListener('load', function() { 
        try {
            var response = JSON.parse(request.responseText);
            if (request.status === 200) {
                successCallback(response);
            } else {
                errorCallback(response);
            }
        } catch (error) {
            console.log("Error", error);
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
        var response = JSON.parse(request.responseText);
        
        if (request.status === 200) {
            successCallback(response);
        } else {
            errorCallback(response);
        }
    });
}