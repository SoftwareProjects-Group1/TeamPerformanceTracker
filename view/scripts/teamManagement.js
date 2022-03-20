$(document).ready(function() {
    getData();
});

function getData() {
    $.post('../../controller/teamManagement.php', { "action": "getData" }, function(data, status) { checkData(data, status) })
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
        Object.values(data["employees"]).filter(e => e["assignedTeam"] == teamID).forEach(employee => {
            engineers += `
            <div id="${employee["employeeID"]}" class="engineerPod">
                <div class="d-inline-block">
                    <span>${employee["employeeName"]}, </span>
                    <span>${employee["employeeRole"]}</span>
                </div>
                <div>
                    <button id="${employee["employeeID"]}-EDIT" class="BTN rounded-3"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button id="${employee["employeeID"]}-DEL" class="BTN rounded-3"><i class="fa-solid fa-x"></i></button>
                </div>
            </div>
            `;
        })
        $("#teamHolder")[0].innerHTML += `
        <div class="teamContainer shadow rounded-3 p-2 d-inline-block" id="${teamID}">
            <div class="d-flex justify-content-between">
                <input id="${team["teamName"]}" value="${team["teamName"]}" class="me-4"></input>
                <button onclick="deleteTeam(this.id)" id="${teamID}-DEL" class="BTN rounded-3"><i class="fa-solid fa-x"></i></button>
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <span class="ms-1">Projects</span>
            <div id="${teamID}-ProjectsContainer p-4" class="projectContainer">
                ${projects}
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <span class="ms-1">Engineers</span>
            <div id="${teamID}-EngineersContainer ms-1">
                ${engineers}
            </div>
        </div>
        `;
    });
}

var lastTeamID;

function deleteTeam(teamID) {
    teamID = teamID.replace("-DEL", "");
    lastTeamID = teamID;
    $('#alertModal').modal('show')
}

function confirmDeleteTeam() {
    $('#alertModal').modal('hide')
    $.post('../../controller/teamManagement.php', { "action": "deleteTeam", "teamID": lastTeamID }, function(data, status) {
        (data, status) => {
            if (status == "success") {
                alert("Team Deleted");
                $(`#${lastTeamID}`).remove();
            } else { alert("Could not delete team, please try again later"); }
        }
    })
}