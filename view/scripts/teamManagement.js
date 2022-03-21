$(document).ready(function() {
    //Once page loads gets team date
    getData();
});

function getData() {
    //Posts to the team management controller, the action is getting team data
    $.post('../controller/teamManagement.php', { "action": "getData" }, function(data, status) { checkData(data, status) })
}

function checkData(data, status) {
    //Checks if the post returned, parses the data, checks if there is any data, loads the teams onto the page if there is
    if (status != "success") { alert("Connection to the DB can't be established, please try later."); return; }
    data = JSON.parse(data);
    if (Object.keys(data["teams"]).length == 0) { alert("No teams have been found, create a new team by clicking on the left!"); return; }
    displayData(data);
}

function displayData(data) {

    //Runs through all teams returned from the query
    Object.values(data["teams"]).forEach(team => {
        var teamID = team["teamID"];
        var projects = "";
        //Runs through all projects in the database, selects only those assigned to the current team its working through, creates a html element to present any projects assigned
        Object.values(data["projects"]).filter(e => e["assignedTeamID"] == teamID).forEach(project => {
            projects += `<div id="${project["projectID"]}" class="projectPod"><span>${project["projectName"]}</span><span class="d-none">${project["projectDescription"]}</span></div>`
        })
        var engineers = "";
        //Runs through all employees in the database, selectes only those assigned to the current team its working through, creates a html element to present any employees assigned
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
            //Adds the newly created html block to the already exisiting team container
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
        //Selects all teams on the page, sorts them by their names and then redisplays the teams in sorted order
        const main = document.querySelector('#teamHolder');
        const divs = [...main.children];
        divs.sort((a, b) => a.id - b.id);
        divs.forEach(div => main.appendChild(div));
    });
}

var lastTeamID;

function deleteTeam(teamID) {
    //Fills the modal out with corrrect information for the delete team function, then shows it
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
    //Once the confirm delete is pressed the modal is hidden, a post is sent to the controller, the controller tries to remove the team projects and all assgined employees from the db
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
    //Posts synchronously to the controller to get all employees
    employeeListData = await $.ajax({
        url: '../controller/teamManagement.php',
        type: 'POST',
        data: { "action": "getEmployees" }
    });
    //Parses the data and sortes alphabetically
    employeeListData = JSON.parse(employeeListData);
    data = employeeListData;
    data.sort((a, b) => a['employeeName'].localeCompare(b['employeeName']));
    var checkBoxes = "";
    //Creates a checkbox for each employee, these are hidden but toggled whenever the employee html element is pressed
    data.forEach(employee => { checkBoxes += `<input class="d-none" type="checkbox" id="${employee["employeeID"]}-ECB">` });
    //Sets the modal content, the table is automatically filled out containing all the employees that were fetched
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
                <tbody id="employeeTB">
                    <tr class="employeeTableRowHeader">
                        <th class="employeeTableHeader" id="1" class="pt-1 pb-1 ps-2">Employee Name</th>
                        <th class="employeeTableHeader" id="2" class="pt-1 pb-1">Employee Role</th>
                        <th class="employeeTableHeader" id="3" class="pt-1 pb-1">Assigned Number of Teams</th>
                    </tr>
                    ${createEmployeeList(data)}
                </tbody>
            </table>
        </div
        <div>${checkBoxes}</div>
    </form>
    `;
    //Selects all employee's being displayed and adds onclick function, function toggles visual colouring to show selection aswell as the earlier added checkboxes
    $('.employeeTableRow').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("employeeTableRowClicked");
            $(`#${$(this)[0].id.replace("-EID", "-ECB")}`).click();
        });
    });
    //Adds an onclick to all table header elements that will run the sort function when clicked
    $('.employeeTableHeader').each(function(i, obj) {
        $(obj).click(function() { sortEmployeeTable(this.id) });
    });
    $('#modalButton').hide();
    $('#alertModal').modal('show')
}

function createEmployeeList(res) {
    //dynamically creates a set of employees to be put into a html table with data passed to it
    var employees = "";
    res.forEach(employee => {
        employees += `
        <tr class="employeeTableRowSpacer"><td></td></tr>
        <tr class="employeeTableRow" id="${employee["employeeID"]}-EID">
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
        `
    })
    return employees;
}
var currentSort = 1;

function sortEmployeeTable(sortType) {
    //When the header items are pressed this runs, this will sort the employees in 3 different ways and then of those 3 it can do ascending and descending
    //The sorted data is passed to the employee element creation function above and the returned data is inserted into the table
    if (sortType == 1) {
        data = employeeListData;
        data.sort((a, b) => a['employeeName'].localeCompare(b['employeeName']));
        if (currentSort == sortType) {
            data = data.reverse();
            sortEmployeeTableData(data);
            currentSort = 0;
            return;
        }
        sortEmployeeTableData(data);
        currentSort = 1;
    }
    if (sortType == 2) {
        data = employeeListData;
        data.sort((a, b) => a['employeeRole'].localeCompare(b['employeeRole']));
        if (currentSort == sortType) {
            data = data.reverse();
            sortEmployeeTableData(data);
            currentSort = 0;
            return;
        }
        sortEmployeeTableData(data);
        currentSort = 2;
    }
    if (sortType == 3) {
        data = employeeListData;
        data.sort((a, b) => { return ((a['assignedTeam'].length - 1) - (b['assignedTeam'].length - 1)) });
        if (currentSort == sortType) {
            data = data.reverse();
            sortEmployeeTableData(data);
            currentSort = 0;
            return;
        }
        sortEmployeeTableData(data);
        currentSort = 3;
    }
}

function sortEmployeeTableData(data) {
    //This readds the needed onclicks to the table once the new sorted elements have been added
    $('#employeeTB').find('.employeeTableRowSpacer').remove()
    $('#employeeTB').find('.employeeTableRow').remove()
    $('#employeeTB')[0].innerHTML += `${createEmployeeList(data)}`;
    $('.employeeTableHeader').each(function(i, obj) {
        $(obj).click(function() { sortEmployeeTable(this.id) });
    });
    $('.employeeTableRow').each(function(i, obj) {
        $(obj).click(function() {
            $(this).toggleClass("employeeTableRowClicked");
            $(`#${$(this)[0].id.replace("-EID", "-ECB")}`).click();
        });
    });
}