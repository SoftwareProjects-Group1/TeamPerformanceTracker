var teamData = {
    "team1": {
        "teamID": 123456789,
        "teamName": "Team One",
        "assignedProjects": {
            "project1": {
                "projectID": 1234567899,
                "projectName": "Project One",
                "projectDescription": "Just a test project"
            },
            "project2": {
                "projectID": 234567899,
                "projectName": "Project Two",
                "projectDescription": "Just a test project"
            },
            "project3": {
                "projectID": 34567899,
                "projectName": "Project Three",
                "projectDescription": "Just a test project"
            },
            "project4": {
                "projectID": 4567899,
                "projectName": "Project Four",
                "projectDescription": "Just a test project"
            },
            "project5": {
                "projectID": 567899,
                "projectName": "Project Five",
                "projectDescription": "Just a test project"
            }
        },
        "assignedEmployees": {
            "james,Owens": {
                "employeeID": 123,
                "employeeName": "James Owens",
                "employeeRole": "Senior Engineer"
            },
            "alex,Jives": {
                "employeeID": 124,
                "employeeName": "Alex Jives",
                "employeeRole": "Engineer"
            },
            "sarah,Smith": {
                "employeeID": 125,
                "employeeName": "Sarah Smith",
                "employeeRole": "Junior Engineer"
            },
            "martin,Hammond": {
                "employeeID": 126,
                "employeeName": "Martin Hammond",
                "employeeRole": "Lead Engineer"
            }
        }
    },
    "team2": {
        "teamID": 12345678989,
        "teamName": "Team Two",
        "assignedProjects": {
            "project1": {
                "projectID": 1234567899,
                "projectName": "Project One",
                "projectDescription": "Just a test project"
            },
            "project2": {
                "projectID": 234567899,
                "projectName": "Project Two",
                "projectDescription": "Just a test project"
            },
            "project3": {
                "projectID": 34567899,
                "projectName": "Project Three",
                "projectDescription": "Just a test project"
            },
            "project4": {
                "projectID": 4567899,
                "projectName": "Project Four",
                "projectDescription": "Just a test project"
            },
            "project5": {
                "projectID": 567899,
                "projectName": "Project Five",
                "projectDescription": "Just a test project"
            }
        },
        "assignedEmployees": {
            "james,Owens": {
                "employeeID": 123,
                "employeeName": "James Owens",
                "employeeRole": "Senior Engineer"
            },
            "alex,Jives": {
                "employeeID": 124,
                "employeeName": "Alex Jives",
                "employeeRole": "Engineer"
            },
            "sarah,Smith": {
                "employeeID": 125,
                "employeeName": "Sarah Smith",
                "employeeRole": "Junior Engineer"
            },
            "martin,Hammond": {
                "employeeID": 126,
                "employeeName": "Martin Hammond",
                "employeeRole": "Lead Engineer"
            }
        }
    },
    "team3": {
        "teamID": 12345678999,
        "teamName": "Team Three",
        "assignedProjects": {
            "project1": {
                "projectID": 1234567899,
                "projectName": "Project One",
                "projectDescription": "Just a test project"
            },
            "project2": {
                "projectID": 234567899,
                "projectName": "Project Two",
                "projectDescription": "Just a test project"
            },
            "project3": {
                "projectID": 34567899,
                "projectName": "Project Three",
                "projectDescription": "Just a test project"
            },
            "project4": {
                "projectID": 4567899,
                "projectName": "Project Four",
                "projectDescription": "Just a test project"
            },
            "project5": {
                "projectID": 567899,
                "projectName": "Project Five",
                "projectDescription": "Just a test project"
            }
        },
        "assignedEmployees": {
            "james,Owens": {
                "employeeID": 123,
                "employeeName": "James Owens",
                "employeeRole": "Senior Engineer"
            },
            "alex,Jives": {
                "employeeID": 124,
                "employeeName": "Alex Jives",
                "employeeRole": "Engineer"
            },
            "sarah,Smith": {
                "employeeID": 125,
                "employeeName": "Sarah Smith",
                "employeeRole": "Junior Engineer"
            },
            "martin,Hammond": {
                "employeeID": 126,
                "employeeName": "Martin Hammond",
                "employeeRole": "Lead Engineer"
            }
        }
    }
}


$(document).ready(function() {
    var data = getData();
    if (data != null)(displayData(data));
});

function getData() {
    //Change to controller post
    return teamData;
}

function displayData(data) {
    Object.values(data).forEach(val => {
        var projects = "";
        Object.values(val["assignedProjects"]).forEach(project => {
            projects += `<div id="${project["projectID"]}" class="projectPod"><span>${project["projectName"]}</span><span class="d-none">${project["projectDescription"]}</span></div>`
        })
        var engineers = "";
        Object.values(val["assignedEmployees"]).forEach(employee => {
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
        console.log(val)
        $("#teamHolder")[0].innerHTML += `
        <div class="teamContainer shadow rounded-3 p-2 d-inline-block" id="${val["teamID"]}">
            <div class="d-flex justify-content-between">
                <input id="${val["teamName"]}" value="${val["teamName"]}" class="me-4"></input>
                <button id="${val["teamID"]}-DEL" class="BTN rounded-3"><i class="fa-solid fa-x"></i></button>
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <span class="ms-1">Projects</span>
            <div id="${val["teamID"]}-ProjectsContainer p-4" class="projectContainer">
                ${projects}
            </div>
            <div class="teamDivider mt-2 mb-2 ms-auto me-auto rounded-3"></div>
            <span class="ms-1">Engineers</span>
            <div id="${val["teamID"]}-EngineersContainer ms-1">
                ${engineers}
            </div>
        </div>
        `;
    })
}