function addBusiness() {
    window.location.href = '../views/add-business.php';
}

function addStage() {
    window.location.href = '../views/add-stage.php';
}

function addTemplate(businessId) {
    window.location.href = '../views/add-template.php?businessId='+businessId;
}

function manageStage(businessId) {
    window.location.href = '../views/manage-stage.php?businessId='+businessId;
}

function deleteTemplate(templateId) {
    var deleteTemplateButton = document.querySelector('[data-id="delete-template-'+templateId+'"]');
    deleteTemplateButton.innerHTML = '(Deleting)';
    deleteTemplateButton.setAttribute('disabled', 'disabled');

    var http = new XMLHttpRequest();
    var url = '../requests/delete-template.php';
    var params = 'templateId='+templateId;
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            if (http.responseText != 'Deleted successfully') {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else if (http.responseText == 'Deleted successfully') {
                setTimeout(() => {
                    deleteTemplateButton.innerHTML = '(Deleted)';
    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);                    
                }, 1000);
            }
        }
    }
    http.send(params);
}

function editTemplate(templateId) {
    window.location.href = '../views/edit-template.php?templateId='+templateId;
}