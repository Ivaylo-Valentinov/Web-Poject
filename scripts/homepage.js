(function () {
    console.log("Entering homepage script");

        requestTakenBooks();
})();

function requestTakenBooks() {
    console.log("Requesting taken books");
    var user = {
        user_id: 1,
    };
    sendRequest('src/homepage.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, load, console.log);
    console.log("After request");

}

/**
 * Handle the received response from the server
 * If there were no errors found on validation, the index.html is loaded.
 * Else the errors are displayed to the user.
 * @param {*} response
 */
function load(response) {
    console.log(response)
    if (response.success) {
        window.location = 'homepage.html';

    } else {
        var errors = document.getElementById('errors');
        console.log("Login error:", errors);
        errors.innerHTML = response.data;
    }
}

function requestCheckedBooksData(){

}

function requestCheckedReferatsData() {

}