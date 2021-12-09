var lightbulb = document.getElementsByClassName('lightbulb__new-task is-read link-regular')[0];
lightbulb.addEventListener('click', function () {
    fetch('/events').then(() => location.reload())
});

// .then(() => location.reload()

