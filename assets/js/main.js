document.onreadystatechange = function () {
    var state = document.readyState;
    if (state == 'interactive') {
        document.querySelector('.loader').style.display = "flex";
        document.querySelector('.loader').style.visibility = "visible";
    } else if (state == 'complete') {
        document.querySelector('.loader').style.visibility = "hidden";
        document.querySelector('body').style.visibility = "visible";
    }
}

function createNotification(message, type) {
    var body = document.querySelector('body');
    var span = document.createElement('span');
    span.setAttribute('class', 'notification-box '+type);
    span.innerHTML = message;
    body.appendChild(span);
}