function updateStageOrder() {
    var updateButton = document.querySelector('.update-button');
    var allSelect = document.querySelectorAll('select');
    var stage = '';
    for (var i = 0; i < allSelect.length; i++) {
        var stageId = allSelect[i].parentNode.previousElementSibling.getAttribute('stage-data-id');
        if (i == allSelect.length - 1) {
            stage += stageId + ',' + allSelect[i].value;
        } else {
            stage += stageId + ',' + allSelect[i].value + '__%__';
        }
    }

    updateButton.innerHTML = 'Updating...';
    updateButton.removeAttribute('onclick');

    var http = new XMLHttpRequest();
    var url = '../requests/update-stage-order.php';
    var params = 'stage='+stage;
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            console.log(http.responseText);
            setTimeout(() => {
                updateButton.innerHTML = 'Updated';

                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }, 1000);
        }
    }
    http.send(params);
}

function renameStage(stageId, businessId) {
    var renameButton = document.querySelector('#rename-button-'+stageId);
    var stageTextBox = document.querySelector('[stage-data-id="'+stageId+'"]');

    var input = document.createElement('input');
    input.setAttribute('class', 'stage-input');
    input.setAttribute('id', 'input-'+stageId);
    input.value = stageTextBox.innerHTML;
    stageTextBox.innerHTML = '';
    stageTextBox.appendChild(input);

    renameButton.innerHTML = 'Save';
    renameButton.setAttribute('onclick', 'saveStage("'+stageId+'", "'+businessId+'")');
}

function saveStage(stageId, businessId) {
    var stageTextBox = document.querySelector('#input-'+stageId);
    var renameButton = document.querySelector('#rename-button-'+stageId);

    // console.log(stageTextBox.value);
    if (stageTextBox.value != '') {
        renameButton.innerHTML = 'Saving';
        renameButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/save-stage-name.php';
        var params = 'businessId='+businessId+'&stageId='+stageId+'&stageName='+stageTextBox.value;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'Renamed Successfully') {
                    setTimeout(() => {
                        renameButton.innerHTML = 'Saved';

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function deleteStage(stageId, businessId) {
    var deleteButton = document.querySelector('#delete-button-'+stageId);
    deleteButton.innerHTML = 'Deleting';

    var http = new XMLHttpRequest();
    var url = '../requests/delete-stage.php';
    var params = 'businessId='+businessId+'&stageId='+stageId;
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            console.log(http.responseText);
            if (http.responseText == 'Deleted Successfully') {
                setTimeout(() => {
                    deleteButton.innerHTML = 'Deleted';

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }, 1000);
            }
        }
    }
    http.send(params);

}