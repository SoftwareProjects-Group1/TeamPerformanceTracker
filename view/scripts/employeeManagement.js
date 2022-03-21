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

    Object.values(data["employees"]).forEach(employee => {
        var employeeID = employee["employeeID"];
        var projects = "";
        Object.values(data["projects"]).filter(e => e["assignedEmployeeID"] == employeeID).forEach(project => {
            projects += `<div id="${project["projectID"]}" class="projectPod"><span>${project["projectName"]}</span><span class="d-none">${project["projectDescription"]}</span></div>`
        })
        var engineers = "";
        Object.values(data["employees"]).filter(e => e["assignedEmployee"] == employeeID).forEach(employee => {
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
        <div class="teamContainer shadow rounded-3 p-2 d-inline-block" id="${employeeID}">
            <div class="d-flex justify-content-between">
                <input id="${employee["employeeName"]}" value="${employee["employeeName"]}" class="me-4"></input>
                <button onclick="deleteEmployee(this.id)" id="${employeeID}-DEL" class="BTN rounded-3"><i class="fa-solid fa-x"></i></button>
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <span class="ms-1">Projects</span>
            <div id="${employeeID}-ProjectsContainer p-4" class="projectContainer">
                ${projects}
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <span class="ms-1">Engineers</span>
            <div id="${employeeID}-EngineersContainer ms-1">
                ${engineers}
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