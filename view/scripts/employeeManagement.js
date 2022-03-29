$(document).ready(function() {
    getData();
});

function getData() {
    $.post('../controller/employeeManagement.php', { "action": "getData" }, function(data, status) { checkData(data, status) })
}

function checkData(data, status) {
    if (status != "success") { alert("Connection to the DB can't be established, please try later."); return; }
    data = JSON.parse(data);
    if (Object.keys(data["employees"]).length == 0) { alert("No employees have been found, create a new employee by clicking on the left!"); return; }
    displayData(data);
}

function displayData(data) {
    Object.values(data["employees"]).forEach(employee =>{
        var employeeID = employee["employeeID"];
        var employeeRole = employee["employeeRole"];

        document.getElementById("employeeHolder").innerHTML += `
        <div class="teamContainer shadow rounded-3 p-2 d-inline-block" id="${employeeID}">
            <div class="d-flex justify-content-between">
                <input id="${employee["employeeName"]}" value="${employee["employeeName"]}" class="me-4"></input>
                <button onclick="deleteTeam(this.id)" id="${employeeID}-DEL" class="BTN rounded-3"><i class="fa-solid fa-x"></i></button>
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <span class="ms-1">Employee's Role</span>
            <div id="${employeeID}-RolesContainer p-4" class="projectContainer">
                ${employeeRole}
            </div>
        </div>
        `;
    });
}

var lastEmployeeID;

function deleteEmployee(employeeID) {
    employeeID = employeeID.replace("-DEL", "");
    lastEmployeeID = employeeID;
    $('#alertModal').modal('show')
}

function confirmDeleteEmployee() {
    $('#alertModal').modal('hide')
    $.post('../controller/employeeManagement.php', { "action": "deleteEmployee", "employeeID": lastEmployeeID }, function(data, status) {
        (data, status) => {
            if (status == "success") {
                alert("Employee Deleted");
                $(`#${lastEmployeeID}`).remove();
            } else { alert("Could not delete employee, please try again later"); }
        }
    })
}

var employeeListData;
var projectListData;

async function createTeamPopup() {
    //Posts synchronously to the controller to get all employees
    employeeListData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getEmployees" }
    });
    //Posts synchronously to the controller to get all projects
    projectListData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getProjects" }
    });
    //Parses the data and sorts alphabetically
    employeeListData = JSON.parse(employeeListData);
    projectListData = JSON.parse(projectListData);
    dataE = employeeListData;
    dataP = projectListData;
    dataE.sort((a, b) => a['employeeName'].localeCompare(b['employeeName']));
    dataP.sort((a, b) => a['projectName'].localeCompare(b['projectName']));
    var checkBoxesE = "";
    var checkBoxesP = "";
    //Creates a checkbox for each employee, these are hidden but toggled whenever the employee html element is pressed
    dataE.forEach(employee => { checkBoxesE += `<input name="${employee["employeeID"]}-ECBN" class="d-none" type="checkbox" id="${employee["employeeID"]}-ECB">` });
    //Creates a checkbox for each project, these are hidden but toggled whenever the project html element is pressed
    dataP.forEach(project => { checkBoxesP += `<input name="${project["projectID"]}-PCBN" class="d-none" type="checkbox" id="${project["projectID"]}-PCB">` });
    //Sets the modal content, the table is automatically filled out containing all the employees and projects that were fetched
    $('#modalTitle')[0].innerText = "Create Team";
    $('#modalContent')[0].innerHTML = `
    <form method="post" id="createTeamForm">
        <div class="form-floating mb-3">
        <input id="teamNameInput" class="form-control" name="tName" placeholder="Team Name" required >
        <label for="teamNameInput">Team Name</label>
        </div>
        <hr>
        <div>Projects (Optional)</div>
        <div class="tableContainer p-1">
            <table class="tableContainerTable w-100">
                <tbody id="projectTB">
                    <tr class="tableRowHeader">
                        <th class="tableHeaderP" id="1P" class="pt-1 pb-1 ps-2">Project Name</th>
                        <th class="tableHeaderP" id="2P" class="pt-1 pb-1">Project Description</th>
                    </tr>
                    ${createProjectList(dataP)}
                </tbody>
            </table>
        </div>
        <hr>
        <div>Engineers (Optional)</div>
        <div class="tableContainer p-1">
            <table class="tableContainerTable w-100">
                <tbody id="employeeTB">
                    <tr class="tableRowHeader">
                        <th class="tableHeaderE" id="1E" class="pt-1 pb-1 ps-2">Employee Name</th>
                        <th class="tableHeaderE" id="2E" class="pt-1 pb-1">Employee Role</th>
                    </tr>
                    ${createEmployeeList(dataE)}
                </tbody>
            </table>
        </div>
        <hr>
        <div>${checkBoxesE}</div>
        <div>${checkBoxesP}</div>
        <button class="btn btn-success w-100">Create Team</button>
    </form>
    `;
    //Selects all employee's being displayed and adds onclick function, function toggles visual colouring to show selection aswell as the earlier added checkboxes
    $('.tableRowE').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("tableRowClicked");
            $(`#${$(this)[0].id.replace("-EID", "-ECB")}`).click();
        });
    });
    //Selects all project's being displayed and adds onclick function, function toggles visual colouring to show selection aswell as the earlier added checkboxes
    $('.tableRowP').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("tableRowClicked");
            $(`#${$(this)[0].id.replace("-PID", "-PCB")}`).click();
        });
    });
    //Adds an onclick to all table header elements that will run the sort function when clicked
    $('.tableHeaderE').each(function(i, obj) {
        $(obj).click(function() { sortTableE(this.id) });
    });
    $('.tableHeaderP').each(function(i, obj) {
        $(obj).click(function() { sortTableP(this.id) });
    });
    //Stops the default action of a form submit and sends the form data to a js function to be handled
    $('#createTeamForm').submit((event) => {
        event.preventDefault();
        handleCreateTeamPost($('#createTeamForm').serializeArray());
    });
    $('#modalButton').hide();
    $('#alertModal').modal('show')
}

function createEmployeeList(res) {
    //dynamically creates a set of employees to be put into a html table with data passed to it
    var employees = "";
    res.forEach(employee => {
        employees += `
        <tr class="tableRowSpacer"><td></td></tr>
        <tr class="tableRowE" id="${employee["employeeID"]}-EID">
            <td class="pt-1 pb-1 ps-2">
                <span>${employee["employeeName"]}</span>
            </td>
            <td class="pt-1 pb-1">
                <span>${employee["employeeRole"]}</span>
            </td>
        </tr>
        `
    })
    return employees;
}

function createProjectList(res) {
    //dynamically creates a set of projects to be put into a html table with data passed to it
    var projects = "";
    res.forEach(project => {
        projects += `
        <tr class="tableRowSpacer"><td></td></tr>
        <tr class="tableRowP" id="${project["projectID"]}-PID">
            <td class="pt-1 pb-1 ps-2">
                <span>${project["projectName"]}</span>
            </td>
            <td class="pt-1 pb-1">
                <span>${project["projectDescription"]}</span>
            </td>
        </tr>
        `
    })
    return projects;
}

var currentSortE = "1E";
var currentSortP = "1P";

function sortTableE(sortType) {
    //When the header items are pressed this runs, this will sort the employees in 2 different ways and then of those 2 it can do ascending and descending
    //The sorted data is passed to the employee element creation function above and the returned data is inserted into the table
    if (sortType == "1E") {
        data = employeeListData;
        data.sort((a, b) => a['employeeName'].localeCompare(b['employeeName']));
        if (currentSortE == sortType) {
            data = data.reverse();
            sortTableDataE(data);
            currentSortE = "0E";
            return;
        }
        sortTableDataE(data);
        currentSortE = "1E";
    }
    if (sortType == "2E") {
        data = employeeListData;
        data.sort((a, b) => a['employeeRole'].localeCompare(b['employeeRole']));
        if (currentSortE == sortType) {
            data = data.reverse();
            sortTableDataE(data);
            currentSortE = "0E";
            return;
        }
        sortTableDataE(data);
        currentSortE = "2E";
    }
}

function sortTableDataE(data) {
    //This reads the needed onclicks to the table once the new sorted elements have been added
    $('#employeeTB').find('.tableRowSpacer').remove()
    $('#employeeTB').find('.tableRowE').remove()
    $('#employeeTB')[0].innerHTML += `${createEmployeeList(data)}`;
    $('.tableHeaderE').each(function(i, obj) {
        $(obj).click(function() { sortTableE(this.id) });
    });
    $('.tableRowE').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("tableRowClicked");
            $(`#${$(this)[0].id.replace("-EID", "-ECB")}`).click();
        });
    });
}

function sortTableP(sortType) {
    //When the header items are pressed this runs, this will sort the projects in 2 different ways and then of those 2 it can do ascending and descending
    //The sorted data is passed to the project element creation function above and the returned data is inserted into the table
    if (sortType == "1P") {
        data = projectListData;
        data.sort((a, b) => a['projectName'].localeCompare(b['projectName']));
        if (currentSortP == sortType) {
            data = data.reverse();
            sortTableDataP(data);
            currentSortP = "0P";
            return;
        }
        sortTableDataP(data);
        currentSortP = "1P";
    }
    if (sortType == "2P") {
        data = projectListData;
        data.sort((a, b) => a['projectDescription'].localeCompare(b['projectDescription']));
        if (currentSortP == sortType) {
            data = data.reverse();
            sortTableDataP(data);
            currentSortP = "0P";
            return;
        }
        sortTableDataP(data);
        currentSortP = "2P";
    }
}

function sortTableDataP(data) {
    //This reads the needed onclicks to the table once the new sorted elements have been added
    $('#projectTB').find('.tableRowSpacer').remove()
    $('#projectTB').find('.tableRowP').remove()
    $('#projectTB')[0].innerHTML += `${createProjectList(data)}`;
    $('.tableHeaderP').each(function(i, obj) {
        $(obj).click(function() { sortTableP(this.id) });
    });
    $('.tableRowP').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("tableRowClicked");
            $(`#${$(this)[0].id.replace("-PID", "-PCB")}`).click();
        });
    });
}

function handleCreateTeamPost(data) {
    var teamName;
    var projects = [];
    var employees = [];
    data.forEach(val => {
        if (val.name.includes("tName")) { teamName = val.value }
        if (val.name.includes("ECBN")) { employees.push(val.name.replace("-ECBN", "")) }
        if (val.name.includes("PCBN")) { projects.push(val.name.replace("-PCBN", "")) }
    })
    $.post('../controller/teamManagement.php', {
            "action": "createTeam",
            "teamName": teamName,
            "projects": projects,
            "employees": employees
        },
        function(data, status) {
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $('#teamHolder')[0].innerHTML = "";
                getData();
                toastr.success("Team created");
            } else {
                toastr.error("Team can't be created at this time please try again later");
            }
        });
}

async function createEmployeePopup(id) {
    teamListData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getTeams" }
    });
    teamListData = JSON.parse(teamListData);
    teamListData.sort((a, b) => a['teamName'].localeCompare(b['teamName']));
    var teams = "";
    teamListData.forEach(team => { teams += `
        <input name="${team['teamID']}-CB" class="teamListCB d-none" type="checkbox" id="${team['teamID']}-CB">
        <label for="${team['teamID']}-CB" class="teamListLable w-100 mt-1 mb-1">${team['teamName']}</label>
    ` });
    $('#modalTitle')[0].innerText = "Create Employee";
    $('#modalContent')[0].innerHTML = `
    <form method="post" id="createEmployeeForm">
        <div class="form-floating mb-3">
        <input id="employeeNameInput" class="form-control" name="eName" placeholder="Employee Name" required >
        <label for="employeeNameInput">Employee Name</label>
        </div>
        <div class="form-floating mb-3">
        <input id="employeeRoleInput" class="form-control" name="eRole" placeholder="Employee Role" required >
        <label for="employeeRoleInput">Employee Role</label>
        </div>
        <div class="form-floating mb-3">
        <input id="employeeEmailInput" class="form-control" name="eEmail" placeholder="Employee Email" required >
        <label for="employeeEmailInput">Employee Email</label>
        </div>
        <hr>
        <div class="mb-2">Assign Employee (Optional)</div>
        <div class="teamsListContainer p-1">
            ${teams}
        </div>
        <button class="btn btn-success w-100 mt-2">Create Employee</button>
    </form>
    `;
    $('#modalButton').hide();
    $('#alertModal').modal('show');
    $('#createEmployeeForm').submit((event) => {
        event.preventDefault();
        handleCreateEmployeePost($('#createEmployeeForm').serializeArray());
    });
}

function handleCreateEmployeePost(data) {
    var employeeName;
    var employeeRole;
    var employeeEmail;
    var assignedTeams = [];
    data.forEach(val => {
        if (val.name.includes("eName")) { employeeName = val.value }
        if (val.name.includes("eRole")) { employeeRole = val.value }
        if (val.name.includes("eEmail")) { employeeEmail = val.value }
        if (val.name.includes("-CB")) { assignedTeams.push(val.name.replace("-CB", "")) }
    });
    $.post('../controller/teamManagement.php', {
            "action": "createEmployee",
            "eName": employeeName,
            "eRole": employeeRole,
            "eEmail": employeeEmail,
            "eTeams": assignedTeams
        },
        function(data, status) {
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $('#teamHolder')[0].innerHTML = "";
                getData();
                toastr.success("Employee created");
            } else {
                toastr.error("Employee can't be created at this time please try again later");
            }
        });
}

async function addEngineer(id) {
    teamID = id.replace("-ADDE", "");
    employeeListData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getEmployees" }
    });
    employeeListData = JSON.parse(employeeListData);
    employeeListData = employeeListData.filter(e => { if (e['assignedTeam'] == null) { return true } else { return !(e['assignedTeam'].map(String).includes(teamID)) } });
    data = employeeListData;
    data.sort((a, b) => a['employeeName'].localeCompare(b['employeeName']));
    var checkBoxes = "";
    data.forEach(employee => { checkBoxes += `<input name="${employee["employeeID"]}-ECBN" class="d-none" type="checkbox" id="${employee["employeeID"]}-ECB">` });
    $('#modalTitle')[0].innerText = "Add Employee";
    $('#modalContent')[0].innerHTML = `
    <form method="post" id="addEmployeeForm">
        <input class="d-none" value="${teamID}" name="teamID">
        <div>Employees</div>
        <div class="tableContainerAddE p-1">
            <table class="tableContainerTable w-100">
                <tbody id="employeeTB">
                    <tr class="tableRowHeader">
                        <th class="tableHeaderE" id="1E" class="pt-1 pb-1 ps-2">Employee Name</th>
                        <th class="tableHeaderE" id="2E" class="pt-1 pb-1">Employee Role</th>
                    </tr>
                    ${createEmployeeList(data)}
                </tbody>
            </table>
        </div>
        <div>${checkBoxes}</div>
        <button class="btn btn-success w-100 mt-2">Add Employees</button>
    </form>
    `;
    $('.tableRowE').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("tableRowClicked");
            $(`#${$(this)[0].id.replace("-EID", "-ECB")}`).click();
        });
    });
    $('.tableHeaderE').each(function(i, obj) {
        $(obj).click(function() { sortTableE(this.id) });
    });
    $('#addEmployeeForm').submit((event) => {
        event.preventDefault();
        handleAddEmployeePost($('#addEmployeeForm').serializeArray());
    });
    $('#modalButton').hide();
    $('#alertModal').modal('show');
}

function handleAddEmployeePost(data) {
    var teamID;
    var assignedEmployees = [];
    data.forEach(val => {
        if (val.name.includes("teamID")) { teamID = val.value }
        if (val.name.includes("ECBN")) { assignedEmployees.push(val.name.replace("-ECBN", "")) }
    });
    $.post('../controller/teamManagement.php', {
            "action": "addEmployee",
            "assignedEmployees": assignedEmployees,
            "teamID": teamID
        },
        function(data, status) {
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $('#teamHolder')[0].innerHTML = "";
                getData();
                toastr.success("Employees Added");
            } else {
                toastr.error("Employees can't be added at this time please try again later");
            }
        });
}

function removeEngineer(obj) {
    id = obj.id.split("-");
    eID = id[0];
    tID = id[2];
    console.log(id, eID, tID)
    $.post('../controller/teamManagement.php', {
            "action": "removeEmployee",
            "eID": eID,
            "tID": tID
        },
        function(data, status) {
            console.log(data, status)
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $(obj)[0].parentNode.parentNode.remove();
                toastr.success("Employee removed");
            } else {
                toastr.error("Employee can't be removed at this time please try again later");
            }
        }
    );
}

function removeProject(obj) {
    pID = obj.id.replace("-DEL");
    $.post('../controller/teamManagement.php', {
            "action": "removeProject",
            "pID": pID
        },
        function(data, status) {
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $(obj)[0].parentNode.remove();
                toastr.success("Project removed");
            } else {
                toastr.error("Project can't be removed at this time please try again later");
            }
        }
    );
}

async function addProject(id) {
    teamID = id.replace("-ADDP", "");
    projectListData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getProjects" }
    });
    projectListData = JSON.parse(projectListData);
    projectListData = projectListData.filter(e => e['assignedTeamID'] == 0);
    data = projectListData;
    data.sort((a, b) => a['projectName'].localeCompare(b['projectName']));
    var checkBoxes = "";
    data.forEach(project => { checkBoxes += `<input name="${project["projectID"]}-PCBN" class="d-none" type="checkbox" id="${project["projectID"]}-PCB">` });
    $('#modalTitle')[0].innerText = "Add Project";
    $('#modalContent')[0].innerHTML = `
    <form method="post" id="addProjectForm">
        <input class="d-none" value="${teamID}" name="teamID">
        <div>Projects</div>
        <div class="tableContainerAddE p-1">
            <table class="tableContainerTable w-100">
                <tbody id="projectTB">
                    <tr class="tableRowHeader">
                        <th class="tableHeaderP" id="1P" class="pt-1 pb-1 ps-2">Project Name</th>
                        <th class="tableHeaderP" id="2P" class="pt-1 pb-1">Project Description</th>
                    </tr>
                    ${createProjectList(data)}
                </tbody>
            </table>
        </div>
        <div>${checkBoxes}</div>
        <button class="btn btn-success w-100 mt-2">Add Projects</button>
    </form>
    `;
    $('.tableRowP').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("tableRowClicked");
            $(`#${$(this)[0].id.replace("-PID", "-PCB")}`).click();
        });
    });
    $('.tableHeaderP').each(function(i, obj) {
        $(obj).click(function() { sortTableP(this.id) });
    });
    $('#addProjectForm').submit((event) => {
        event.preventDefault();
        handleAddProjectPost($('#addProjectForm').serializeArray());
    });
    $('#modalButton').hide();
    $('#alertModal').modal('show');
}

function handleAddProjectPost(data) {
    var teamID;
    var assignedProjects = [];
    data.forEach(val => {
        if (val.name.includes("teamID")) { teamID = val.value }
        if (val.name.includes("PCBN")) { assignedProjects.push(val.name.replace("-PCBN", "")) }
    });
    $.post('../controller/teamManagement.php', {
            "action": "addProject",
            "assignedProjects": assignedProjects,
            "teamID": teamID
        },
        function(data, status) {
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $('#teamHolder')[0].innerHTML = "";
                getData();
                toastr.success("Projects Added");
            } else {
                toastr.error("Projects can't be added at this time please try again later");
            }
        });
}

async function editEngineer(eID) {
    eID = eID.replace("-EDIT", "");
    engineerData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getEngineer", "eID": eID }
    });
    engineerData = JSON.parse(engineerData);
    console.log(engineerData);
    $('#modalTitle')[0].innerText = "Edit Engineer";
    $('#modalContent')[0].innerHTML = `
    <form method="post" id="editEngineerForm">
        <input class="d-none" value="${engineerData[1]['employeeID']}" name="eID">
        <div class="form-floating mb-3">
        <input id="employeeNameInput" class="form-control" name="eName" value="${engineerData[1]['employeeName']}" required >
        <label for="employeeNameInput">Employee Name</label>
        </div>
        <div class="form-floating mb-3">
        <input id="employeeRoleInput" class="form-control" name="eRole" value="${engineerData[1]['employeeRole']}" required >
        <label for="employeeRoleInput">Employee Role</label>
        </div>
        <div class="form-floating mb-3">
        <input id="employeeEmailInput" class="form-control" type="email" name="eEmail" value="${engineerData[1]['employeeEmail']}" required >
        <label for="employeeEmailInput">Employee Email</label>
        </div>
        <button class="btn btn-success w-100 mt-2">Save Changes</button>
    </form>
    `;
    $('#editEngineerForm').submit((event) => {
        event.preventDefault();
        handleEditEngineerPost($('#editEngineerForm').serializeArray());
    });
    $('#modalButton').hide();
    $('#alertModal').modal('show');
}

function handleEditEngineerPost(data) {
    var eID;
    var eName;
    var eRole;
    var eEmail;
    data.forEach(val => {
        if (val.name.includes("eID")) { eID = val.value }
        if (val.name.includes("eName")) { eName = val.value }
        if (val.name.includes("eRole")) { eRole = val.value }
        if (val.name.includes("eEmail")) { eEmail = val.value }
    });
    $.post('../controller/teamManagement.php', {
            "action": "editEngineer",
            "eID": eID,
            "eName": eName,
            "eRole": eRole,
            "eEmail": eEmail
        },
        function(data, status) {
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $('#teamHolder')[0].innerHTML = "";
                getData();
                toastr.success("Engineer Edited");
            } else {
                toastr.error("Engineer can't be edited at this time please try again later");
            }
        });
}

async function editTeam(obj) {
    tID = obj.id.replace("-EDIT", "");
    var tName = $(obj)[0].parentNode.parentNode.children[0].innerText;
    $('#modalTitle')[0].innerText = "Edit Team Name";
    $('#modalContent')[0].innerHTML = `
    <form method="post" id="editTeamForm">
        <input class="d-none" value="${tID}" name="tID">
        <div class="form-floating mb-3">
        <input id="teamNameInput" class="form-control" name="tName" value="${tName}" required >
        <label for="teamNameInput">Team Name</label>
        </div>
        <button class="btn btn-success w-100 mt-2">Save Changes</button>
    </form>
    `;
    $('#editTeamForm').submit((event) => {
        event.preventDefault();
        handleEditTeamPost($('#editTeamForm').serializeArray());
    });
    $('#modalButton').hide();
    $('#alertModal').modal('show');
}

function handleEditTeamPost(data) {
    var tID;
    var tName;
    data.forEach(val => {
        if (val.name.includes("tID")) { tID = val.value }
        if (val.name.includes("tName")) { tName = val.value }
    });
    $.post('../controller/teamManagement.php', {
            "action": "editTeam",
            "tID": tID,
            "tName": tName
        },
        function(data, status) {
            data = JSON.parse(data);
            $('#modalContent')[0].innerHTML = "";
            $('#alertModal').modal('hide')
            if (data[0] == true) {
                $('#teamHolder')[0].innerHTML = "";
                getData();
                toastr.success("Team Name Edited");
            } else {
                toastr.error("Team Name can't be edited at this time please try again later");
            }
        });
}