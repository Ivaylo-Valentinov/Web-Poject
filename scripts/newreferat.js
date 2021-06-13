(function() {
    var submitButton = document.getElementById('add-referat-btn');
  
    submitButton.addEventListener('click', sendForm);
})();
  
function sendForm(event) {
     event.preventDefault();

    var title = document.getElementById('title').value;
    var author = document.getElementById('author').value;
    var desc = document.getElementById('desc').value;
    var count = document.getElementById('count').value;
    var link = document.getElementById('link').value;

    if (!link) {
        errors.innerHTML = "You should upload a referat link!";
        return;
    }

    var formdata = new FormData();

    formdata.append('title', title);
    formdata.append('author', author);
    formdata.append('desc', desc);
    formdata.append('count', count);
    formdata.append('type', "ref");
    formdata.append('link', link);

    

    var request = new XMLHttpRequest();
    request.open('POST', 'src/referats.php', true);
    request.send(formdata);
    request.addEventListener('load', function() {
        var response = JSON.parse(request.responseText);
        
        if (request.status === 200) {
            onAddedBook();
        } else {
            onError(response);
        }
    });
}
  

function onAddedBook() {
    alert("Success");
    window.location = 'index.html';
}

function onError(response) {
    var errors = document.getElementById('errors');
    errors.innerHTML = response;
}