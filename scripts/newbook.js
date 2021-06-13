(function() {
    var submitButton = document.getElementById('add-book-btn');
  
    submitButton.addEventListener('click', sendForm);
})();
  
function sendForm(event) {
     event.preventDefault();

    var title = document.getElementById('title').value;
    var author = document.getElementById('author').value;
    var desc = document.getElementById('desc').value;
    var count = document.getElementById('count').value;
    var type = document.getElementById('type').value;
    var file = document.getElementById('file').files[0];

    if (!file) {
        errors.innerHTML = "You should upload a book!";
        return;
    }

    var formdata = new FormData();

    formdata.append('title', title);
    formdata.append('author', author);
    formdata.append('desc', desc);
    formdata.append('count', count);
    formdata.append('type', type);

    formdata.append("file", file, file.name);

    var request = new XMLHttpRequest();
    request.open('POST', 'src/books.php', true);
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