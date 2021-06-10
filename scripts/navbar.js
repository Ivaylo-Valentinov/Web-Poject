(function(){

    var scaleBtn = document.getElementById('homeLink');
    scaleBtn.addEventListener('click', setHomepage);

    var rotateBtn = document.getElementById('referatsLink');
    rotateBtn.addEventListener('click', setReferatsPage);

    var skewBtn = document.getElementById('booksLink');
    skewBtn.addEventListener('click', setBooksPage);

    var leafFall = document.getElementById('statisticsLink');
    leafFall.addEventListener('click', setStatisticsPage);

    var leafFall = document.getElementById('profileLink');
    leafFall.addEventListener('click', setProfilePage);

})();

function setHomepage(event){
    event.preventDefault();

    var home = document.getElementById('homeLink');
    if(home.className !== 'active') {
        var current = document.getElementsByClassName('active')[0];
        current.classList.toggle('unactive');
        home.classList.toggle('active');
    }

    window.location = 'homepage.html';

}

function setReferatsPage(event){
    event.preventDefault();

    var ref = document.getElementById('referatsLink');
    if(ref.className !== 'active'){
        var current = document.getElementsByClassName('active')[0];
        current.classList.toggle('unactive');
        ref.classList.toggle('active');
    }

    window.location = 'referats.html';
}

function setBooksPage(event){
    event.preventDefault();

    var book = document.getElementById('booksLink');

    if(book.className !== 'active'){
        var current = document.getElementsByClassName('active')[0];
        current.classList.toggle('unactive');
        book.classList.toggle('active');
    }

}

function setStatisticsPage(event){
    event.preventDefault();

    var stat = document.getElementById('statisticsLink');
    if(stat.className !== 'active') {
        var current = document.getElementsByClassName('active')[0];
        current.classList.toggle('unactive');
        stat.classList.toggle('active');
    }

}

function setProfilePage(event){
    event.preventDefault();

    var profile = document.getElementById('profileLink');
    if(profile.className !== 'active') {
        var current = document.getElementsByClassName('active')[0];
        current.classList.toggle('unactive');
        profile.classList.toggle('active');
    }

}