function addBusiness() {
    window.location.href = '../views/add-business.php';
}

function selectTeam(team) {
    var currentSelectTeamId = document.querySelector('[team-data="'+team+'"]');
    if (currentSelectTeamId.getAttribute('class') == null) {
        currentSelectTeamId.setAttribute('class', 'active');
        currentSelectTeamId.setAttribute('team-data-selected', 'true');
    } else {
        currentSelectTeamId.removeAttribute('class');
        currentSelectTeamId.removeAttribute('team-data-selected');
    }
}

function addStage() {
    var addButton = document.querySelector('.add-button');

    var stageName = document.querySelector('#stage-name');

    var allselectedTeamId = document.querySelectorAll('[team-data-selected="true"]');
    var teamId = '';
    for (let i = 0; i < allselectedTeamId.length; i++) {
        if (i === allselectedTeamId.length - 1) {
            teamId += allselectedTeamId[i].getAttribute('team-data');
        } else {
            teamId += allselectedTeamId[i].getAttribute('team-data') + ',';
        }
    }

    if (stageName.value != '' && teamId != '') {
        addButton.innerHTML = 'Adding';
        addButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/add-stage.php';
        var params = 
        'stageName='+stageName.value+
        '&teamId='+teamId;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'Stage Inserted') {
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
                            addButton.setAttribute('onclick', 'addStage()');
                        }, 2000);
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}