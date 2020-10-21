

function loadlink() {
    var scheduleCallPopup = document.querySelector('.schedule-call-popup');
    var http = new XMLHttpRequest();
    var url = '../requests/get-schedule-call.php';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            // console.log(http.responseText);
            if (http.responseText != '') {
                scheduleCallPopup.innerHTML = '';
                var notification = document.createElement('div');
                notification.setAttribute('class', 'schedule-heading');
                notification.innerHTML = '<span>Call Alert</span><i class="icon-x-circle" onclick="closeCallPopup()"></i>';
                scheduleCallPopup.appendChild(notification);

                var responses = http.responseText.split('__%%__');
                for (var i = 0; i < responses.length; i++) {
                    if (responses[i] != '') {
                        var singleResponses = responses[i].split('__%__');
                        var clientId = singleResponses[0];
                        var clientName = singleResponses[1].toLowerCase().toUpperCase();
                        var clientMobile = singleResponses[2];
                        var clientScheduleCall = singleResponses[3];
                        var clientTimeLeft = singleResponses[4];
                                                    
                        var responseBox = document.createElement('div');
                        responseBox.setAttribute('class', 'popup-main');
                        responseBox.setAttribute('data-client-id', clientId);
                        responseBox.innerHTML = 
                        '<span class="client-name-popup">'+clientTimeLeft+' minutes left to call '+clientName+'</span>'+
                        '<span>Schedule Date: '+clientScheduleCall+'</span>'+
                        '<span>Call: '+clientMobile+'</span>';
                        scheduleCallPopup.appendChild(responseBox);
                        scheduleCallPopup.style.transform = 'translateY(0%)';
                    }
                }
            } else {
                scheduleCallPopup.style.transform = 'translateY(140%)';
                setTimeout(() => {
                    scheduleCallPopup.innerHTML = '';
                }, 1000);
            }
        }
    }
    http.send();
}

loadlink();

var time = new Date(),
secondsRemaining = ((60 - time.getSeconds()) * 1000) + 1000;
setTimeout(function() {
    loadlink();
    setInterval(function() {
        loadlink();
    }, 60000);
}, secondsRemaining);

function closeCallPopup() {
    var scheduleCallPopup = document.querySelector('.schedule-call-popup');
    scheduleCallPopup.style.transform = 'translateY(140%)';
}