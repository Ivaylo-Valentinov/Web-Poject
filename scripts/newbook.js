(function() {
    var submitButton = document.getElementById('add-book-btn');
  
    submitButton.addEventListener('click', sendForm);
})();
  
function sendForm(event) {
     event.preventDefault();
  //TO DO add validations
    var title = document.getElementById('title').value;
    var author = document.getElementById('author').value;
    var desc = document.getElementById('desc').value;
    var count = document.getElementById('count').value;
    var type = document.getElementById('type').value;
    var file = document.getElementById('file').files[0];

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

        if (request.status === 200) {
            load(request.responseText);
        } else {
            console.log(request.responseText);
        }
    });
}
  

function load(response) {

    if(response.success) {
        // window.location = 'login.html';
        alert("Success");
        console.log(response);
    } else {
        var errors = document.getElementById('errors');
        errors.innerHTML = response;
    }
}
