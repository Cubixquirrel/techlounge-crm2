function openAddEmail() {
    window.location.href = '../views/add-email.php';
}

function previewMail() {
    var previewMailBox = document.querySelector('.preview-mail-box');
    previewMailBox.innerHTML = '';
    var campaignMessage = document.querySelector('#campaign-message');
    var previewInnerBox = document.createElement('div');
    previewInnerBox.setAttribute('class', 'preview-inner-box')
    previewInnerBox.innerHTML = campaignMessage.value;
    previewMailBox.appendChild(previewInnerBox);
    previewMailBox.style.display = 'block';
}

function sendCampaign() {
    var campaignName = document.querySelector('#campaign-name');
    var campaignScheduleTime = document.querySelector('#campaign-schedule-time');
    var campaignEmailGroup = document.querySelector('#campaign-email-group');
    var campaignEmailGroupType = document.querySelector('#campaign-email-group-type');
    var campaignFromEmail = document.querySelector('#campaign-from-email');
    var campaignSubject = document.querySelector('#campaign-subject');
    var campaignMessage = document.querySelector('#campaign-message');
    var sendButton = document.querySelector('.send-button');

    campaignName.style.border = '2px solid #8a8a8a';
    campaignScheduleTime.style.border = '2px solid #8a8a8a';
    campaignEmailGroup.style.border = '2px solid #8a8a8a';
    campaignEmailGroupType.style.border = '2px solid #8a8a8a';
    campaignFromEmail.style.border = '2px solid #8a8a8a';
    campaignSubject.style.border = '2px solid #8a8a8a';
    campaignMessage.style.border = '2px solid #8a8a8a';

    if (
        (campaignName.value != '') && (campaignScheduleTime.value != '') && (campaignEmailGroup.value != '') && 
        (campaignEmailGroupType.value != '') && (campaignFromEmail.value != '') && (campaignSubject.value != '') && (campaignMessage.value != '')
    ) {
        sendButton.innerHTML = 'Sending...';
        sendButton.style.cursor = 'wait';
        sendButton.removeAttribute('onclick');
        
        var http = new XMLHttpRequest();
        var url = '../requests/send-campaign.php';
        var params = 
        'campaignName='+campaignName.value+
        '&campaignScheduleTime='+campaignScheduleTime.value+
        '&campaignEmailGroup='+campaignEmailGroup.value+
        '&campaignEmailGroupType='+campaignEmailGroupType.value+
        '&campaignFromEmail='+campaignFromEmail.value+
        '&campaignSubject='+campaignSubject.value+
        '&campaignMessage='+campaignMessage.value;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'true') {
                    setTimeout(() => {
                        sendButton.innerHTML = 'Campaign Started Successfully';

                        setTimeout(() => {
                            window.location.reload();
                        }, 2500);
                    }, 2000);
                } else {
                    setTimeout(() => {
                        sendButton.innerHTML = 'Campaign Failed';
                        sendButton.style.background = 'linear-gradient(120deg, #ff5934 0%, #a50000 100%)';

                        setTimeout(() => {
                            sendButton.innerHTML = 'Send';
                            sendButton.style.background = 'linear-gradient(120deg, #00b5fd 0%, #0047b1 100%)';
                            sendButton.setAttribute('onclick', 'sendCampaign()');
                            sendButton.style.cursor = 'pointer';
                        }, 2000);                            
                    }, 2000);
                }
            }
        }
        http.send(params);
    } else {
        if (campaignName.value == '') {
            campaignName.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (campaignScheduleTime.value == '') {
            campaignScheduleTime.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (campaignEmailGroup.value == '') {
            campaignEmailGroup.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (campaignEmailGroupType.value == '') {
            campaignEmailGroupType.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (campaignFromEmail.value == '') {
            campaignFromEmail.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (campaignSubject.value == '') {
            campaignSubject.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (campaignMessage.value == '') {
            campaignMessage.style.border = '2px solid rgb(244, 67, 54)';
        }
    }
}