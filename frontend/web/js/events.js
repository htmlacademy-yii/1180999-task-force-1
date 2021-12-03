var lightbulb = document.getElementsByClassName('header__lightbulb')[0];
lightbulb.addEventListener('mouseover', function () {
    fetch('/events');
});

