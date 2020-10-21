function selectRole(role) {
    var currentSelectRoleId = document.querySelector('[role-data="'+role+'"]');
    var editorFormGroup = document.querySelector('#editor-form-group');
    if (currentSelectRoleId.getAttribute('class') == null) {
        currentSelectRoleId.setAttribute('class', 'active');
        currentSelectRoleId.setAttribute('role-data-selected', 'true');
    } else {
        currentSelectRoleId.removeAttribute('class');
        currentSelectRoleId.removeAttribute('role-data-selected');
    }

    if (role == 'Editor') {
        if (editorFormGroup.getAttribute('style') == 'display: none;') {
            editorFormGroup.setAttribute('style', 'display: block;');
        } else {
            editorFormGroup.setAttribute('style', 'display: none;');
        }
    }
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

function updateUser(userId) {
    var updateButton = document.querySelector('.update-button');

    var userName = document.querySelector('#user-name');
    var userEmail = document.querySelector('#user-email');
    var userPassword = document.querySelector('#user-password');
    var userWebsite = document.querySelector('#user-website');

    var allselectedRoleId = document.querySelectorAll('[role-data-selected="true"]');
    var roleId = '';
    for (let i = 0; i < allselectedRoleId.length; i++) {
        if (i === allselectedRoleId.length - 1) {
            roleId += allselectedRoleId[i].getAttribute('role-data');
        } else {
            roleId += allselectedRoleId[i].getAttribute('role-data') + ',';
        }
    }

    var allselectedTeamId = document.querySelectorAll('[team-data-selected="true"]');
    var teamId = '';
    for (let i = 0; i < allselectedTeamId.length; i++) {
        if (i === allselectedTeamId.length - 1) {
            teamId += allselectedTeamId[i].getAttribute('team-data');
        } else {
            teamId += allselectedTeamId[i].getAttribute('team-data') + ',';
        }
    }

    if (userName.value != '' && userEmail.value != '' && userPassword.value != '' && roleId != '' && teamId != '') {
        updateButton.innerHTML = 'Updating';
        updateButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/update-user.php';
        var params = 
        'userId='+userId+
        '&userName='+userName.value+
        '&userEmail='+userEmail.value+
        '&userPassword='+userPassword.value+
        '&userWebsite='+userWebsite.value+
        '&roleId='+roleId+
        '&teamId='+teamId;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'User Updated') {
                    setTimeout(() => {
                        updateButton.innerHTML = 'Updated';

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                } else {
                    setTimeout(() => {
                        updateButton.innerHTML = http.responseText;
                        updateButton.setAttribute('class', 'update-button error');

                        setTimeout(() => {
                            updateButton.innerHTML = 'Update';
                            updateButton.setAttribute('class', 'update-button');
                            updateButton.setAttribute('onclick', 'updateUser("'+userId+'")');
                        }, 2000);
                    }, 1000);
                }
            }
        }
        http.send(params);
        
        // console.log(roleId, teamId);
    }
}

function addBusiness() {
    window.location.href = '../views/add-business.php';
}