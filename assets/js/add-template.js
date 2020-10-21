function selectStage(team) {
    var allStageId = document.querySelectorAll('.stage-box span');
    for (var i = 0; i < allStageId.length - 1; i++) {
        allStageId[i].removeAttribute('class');
        allStageId[i].removeAttribute('stage-data-selected');
    }
    
    var currentSelectStageId = document.querySelector('[stage-data="'+team+'"]');
    if (currentSelectStageId.getAttribute('class') == null) {
        currentSelectStageId.setAttribute('class', 'active');
        currentSelectStageId.setAttribute('stage-data-selected', 'true');
    } else {
        currentSelectStageId.removeAttribute('class');
        currentSelectStageId.removeAttribute('stage-data-selected');
    }
}

function addTemplate(businessId) {
    var addButton = document.querySelector('.add-button');

    var templateName = document.querySelector('#template-name');
    var templateSubject = document.querySelector('#template-subject');
    var templateMessage = document.querySelector('#template-message');

    var allselectedStageId = document.querySelectorAll('[stage-data-selected="true"]');
    var stageId = '';
    for (let i = 0; i < allselectedStageId.length; i++) {
        if (i === allselectedStageId.length - 1) {
            stageId += allselectedStageId[i].getAttribute('stage-data');
        } else {
            stageId += allselectedStageId[i].getAttribute('stage-data') + ',';
        }
    }

    if (templateName.value != '' && templateSubject.value != '' && templateMessage.value != '' && stageId != '') {
        addButton.innerHTML = 'Adding';
        addButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/add-template.php';
        var params = 
        'businessId='+businessId+
        '&templateName='+templateName.value+
        '&templateSubject='+templateSubject.value+
        '&templateMessage='+templateMessage.value+
        '&stageId='+stageId;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'Template Added') {
                    setTimeout(() => {
                        addButton.innerHTML = 'Added';

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                } else {
                    setTimeout(() => {
                        addButton.innerHTML = http.responseText;
                        addButton.setAttribute('class', 'add-button error');

                        setTimeout(() => {
                            addButton.innerHTML = 'Add';
                            addButton.setAttribute('class', 'add-button');
                            addButton.setAttribute('onclick', 'addTemplate("'+businessId+'")');                           
                        }, 2000);
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function addStage() {
    window.location.href = '../views/add-stage.php';
}