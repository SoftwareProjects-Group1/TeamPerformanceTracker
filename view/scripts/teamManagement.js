$(document).ready(function() {
    getData();
});

function getData() {
    $.post('../controller/teamManagement.php', { "action": "getData" }, function(data, status) { checkData(data, status) })
}

function checkData(data, status) {
    if (status != "success") { alert("Connection to the DB can't be established, please try later."); return; }
    data = JSON.parse(data);
    if (Object.keys(data["teams"]).length == 0) { alert("No teams have been found, create a new team by clicking on the left!"); return; }
    displayData(data);
}

function displayData(data) {

    Object.values(data["teams"]).forEach(team => {
        var teamID = team["teamID"];
        var projects = "";
        Object.values(data["projects"]).filter(e => e["assignedTeamID"] == teamID).forEach(project => {
            projects += `<div id="${project["projectID"]}" class="projectPod"><span>${project["projectName"]}</span><span class="d-none">${project["projectDescription"]}</span></div>`
        })
        var engineers = "";
        Object.values(data["employees"]).filter(e => e["assignedTeam"].includes(teamID)).forEach(employee => {
            engineers += `
            <div id="${employee["employeeID"]}" class="engineerPod">
                <div class="d-inline-block">
                    <span>${employee["employeeName"]}, </span>
                    <span>${employee["employeeRole"]}</span>
                </div>
                <div>
                    <button data-toggle="tooltip" data-placement="top" title="Edit Engineer" id="${employee["employeeID"]}-EDIT" class="BTN rounded-3"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button data-toggle="tooltip" data-placement="top" title="Remove Engineer" id="${employee["employeeID"]}-DEL" class="BTN rounded-3"><i class="fa-solid fa-x"></i></button>
                </div>
            </div>
            `;
        })
        $("#teamHolder")[0].innerHTML += `
        <div class="teamContainer shadow rounded-3 p-2 d-inline-block" id="${teamID}">
            <div class="d-flex justify-content-between">
                <input id="${team["teamName"]}" value="${team["teamName"]}" class="me-4"></input>
                <button data-toggle="tooltip" data-placement="top" title="Delete Team" onclick="deleteTeam(this.id)" id="${teamID}-DEL" class="BTN rounded-3 me-1"><i class="fa-solid fa-x"></i></button>
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <div class="d-flex justify-content-between">
                <span class="ms-1">Projects</span>
                <button data-toggle="tooltip" data-placement="top" title="Add Projects" onclick="addProject(this.id)" id="${teamID}-ADDP" class="BTN rounded-3 me-1"><i class="fa-solid fa-plus"></i></button>
            </div>
            
            <div id="${teamID}-ProjectsContainer p-4" class="projectContainer">
                ${projects}
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <div class="d-flex justify-content-between">
                <span class="ms-1">Engineers</span>
                <button data-toggle="tooltip" data-placement="top" title="Add Engineers" onclick="addEngineer(this.id)" id="${teamID}-ADDE" class="BTN rounded-3 me-1"><i class="fa-solid fa-plus"></i></button>
            </div>
            <div id="${teamID}-EngineersContainer ms-1">
                ${engineers}
            </div>
        </div>
        `;
        const main = document.querySelector('#teamHolder');
        const divs = [...main.children];
        divs.sort((a, b) => a.id - b.id);
        divs.forEach(div => main.appendChild(div));
    });
}

var lastTeamID;

function deleteTeam(teamID) {
    teamID = teamID.replace("-DEL", "");
    lastTeamID = teamID;
    $('#modalTitle')[0].innerText = "Are you sure?";
    $('#modalContent')[0].innerHTML = `<p>Are you sure you wish to delete this team, this is unreversible and will remove the team completely from the database. All Projects and Employees assigned will be set to unassigned.</p>`;
    $('#modalButton')[0].innerText = "Delete Team";
    $('#modalButton').attr("onclick", "confirmDeleteTeam()");
    $('#modalButton').show();
    $('#alertModal').modal('show')
}

function confirmDeleteTeam() {
    $('#alertModal').modal('hide')
    $.post('../controller/teamManagement.php', { "action": "deleteTeam", "teamID": lastTeamID }, function(data, status) {
        if (status == "success") {
            alert("Team Deleted");
            $(`#${lastTeamID}`).remove();
        } else { alert("Could not delete team, please try again later"); }
    })
}

var employeeListData;

async function createTeamPopup() {
    employeeListData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getEmployees" }
    });
    employeeListData = JSON.parse(employeeListData);
    $('#modalTitle')[0].innerText = "Create Team";
    $('#modalContent')[0].innerHTML = `
    <form>
        <div class="form-floating mb-3">
        <input id="teamNameInput" class="form-control" name="tName" placeholder="Team Name" required >
        <label for="teamNameInput">Team Name</label>
        </div>
        <hr>
        Projects
        <hr>
        <div>Engineers</div>
        <div class="employeeTableContainer p-1">
            <table class="employeeTable w-100">
                <tbody class="" id="employeeTB">
                    <tr class="employeeTableRowHeader">
                        <th class="pt-1 pb-1 ps-2">Employee Name</th>
                        <th class="pt-1 pb-1">Employee Role</th>
                        <th class="pt-1 pb-1">Assigned Number of Teams</th>
                    </tr>
                    <tr class="employeeTableRowSpacer"><td></td></tr>
                    ${createEmployeeList(employeeListData)}
                </tbody>
            </table>
        </div
    </form>
    `;
    $('.employeeTableRow').each(function(i, obj) {
        $(obj).click(function() { $(this).toggleClass("employeeTableRowClicked") });
    });
    $('#modalButton').hide();
    $('#alertModal').modal('show')
}

function createEmployeeList(res) {
    var employees = "";
    res.forEach(employee => {
        employees += `
        <tr class="employeeTableRow">
            <td class="pt-1 pb-1 ps-2">
                <span>${employee["employeeName"]}</span>
            </td>
            <td class="pt-1 pb-1">
                <span>${employee["employeeRole"]}</span>
            </td>
            <td class="pt-1 pb-1">
                <span>${employee["assignedTeam"].length-1}</span>
            </td>
            
        </tr>
        <tr class="employeeTableRowSpacer"><td></td></tr>
        `
    })
    return employees;
}