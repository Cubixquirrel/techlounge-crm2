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

function addUser() {
    var addButton = document.querySelector('.add-button');

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
        addButton.innerHTML = 'Adding';
        addButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/add-user.php';
        var params = 
        'userName='+userName.value+
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
                if (http.responseText == 'User Inserted') {
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
                            addButton.setAttribute('onclick', 'addUser()');
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