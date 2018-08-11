$(document).ready(() => {
    // load home effects
    $('#container').fadeIn(2000);
    $('#container').css({"display": "flex"});

    setTimeout(() => {
        $('#container').animate({"height": "80vh"});

        $('#buttons').fadeIn(2000);
        $('#buttons').css({"display": "flex"});
    }, 2000);
});
