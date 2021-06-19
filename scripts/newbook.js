(function() {
    var submitSingle = document.getElementById('add-book-btn');
    var submitMultiple = document.getElementById('multiple-books-btn');
  
    submitSingle.addEventListener('click', sendSingleForm);
    submitMultiple.addEventListener('click', sendMultipleForm);
})();
  
function sendSingleForm(event) {
     event.preventDefault();

    var title = document.getElementById('title').value;
    var author = document.getElementById('author').value;
    var desc = document.getElementById('desc').value;
    var count = document.getElementById('count').value;
    var type = document.getElementById('type').value;
    var url = type === 'Book' ? 'src/books.php' : 'src/referats.php';
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

    formdata.append("file", file);

    sendMultipartDataRequest(url, { method: 'POST', formdata: formdata }, onSuccess, onError);
}

function sendMultipleForm(event) {
    event.preventDefault();

    var files = document.getElementById('multiple-files').files;

    if (!files) {
        errors.innerHTML = "You should upload content!";
        return;
    }

    var formdata = new FormData();

    console.log(files);
    for (var i = 0; i < files.length; ++i) {
        formdata.append("files[]", files[i]);
    }

    sendMultipartDataRequest('src/multipleContent.php', { method: 'POST', formdata: formdata }, onSuccess, onError);
}

function onSuccess() {
    alert("Success");
    window.location = 'index.html';
}

function onError(response) {
    var errors = document.getElementById('errors');
    errors.innerHTML = response;
}