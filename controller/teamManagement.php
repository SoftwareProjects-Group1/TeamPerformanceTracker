<?php
session_start();
include 'DBConn.php';
use MongoDB\Driver as Mongo;
$CONN;
if(isset($GLOBALS['DBConnStatus']) && $GLOBALS['DBConnStatus']==true){
    $CONN=$GLOBALS['DBConn'];
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='getData')){
    $teams=[];
    $employees=[];
    $projects=[];
    $q = new Mongo\Query([],[]);
    $cursor = $CONN->executeQuery('projectDB.Teams',$q);
    foreach($cursor as $team) {
        $teams[]=$team;
    }
    $cursor = $CONN->executeQuery('projectDB.Employees',$q);
    foreach($cursor as $team) {
        $employees[]=$team;
    }
    $cursor = $CONN->executeQuery('projectDB.Projects',$q);
    foreach($cursor as $team) {
        $projects[]=$team;
    }
    echo json_encode(["teams"=>$teams,"employees"=>$employees,"projects"=>$projects]);
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='deleteTeam')){
    $teamID=$_POST['teamID'];

    //Delete team from the teams collection
    $bulk = new Mongo\BulkWrite;
    $filter = ["teamID"=>$teamID];
    $bulk->delete($filter,['limit' => 1]);
    $res = $CONN->executeBulkWrite('projectDB.Teams', $bulk);

    //Unassign Employees from the team
    $bulk = new Mongo\BulkWrite;
    $filter = ["assignedTeam"=>$teamID];
    $bulk->update($filter, ['$pull'=>["assignedTeam"=>$teamID]], []);
    $res = $CONN->executeBulkWrite('projectDB.Employees', $bulk);

    //Unassign Projects from the team
    $bulk = new Mongo\BulkWrite;
    $filter = ["assignedTeamID"=>$teamID];
    $bulk->update($filter, ['$set'=>["assignedTeamID"=>0]], []);
    $res = $CONN->executeBulkWrite('projectDB.Projects', $bulk);

    
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='getEmployees')){
    $q = new Mongo\Query([],[]);
    $employees=[];
    $cursor = $CONN->executeQuery('projectDB.Employees',$q);
    foreach($cursor as $employee) {
        $employees[]=$employee;
    }
    echo json_encode($employees);
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='getProjects')){
    $q = new Mongo\Query(['assignedTeamID' =>0],[]);
    $projects=[];
    $cursor = $CONN->executeQuery('projectDB.Projects',$q);
    foreach($cursor as $project) {
        $projects[]=$project;
    }
    echo json_encode($projects);
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='getTeams')){
    $q = new Mongo\Query([],[]);
    $teams=[];
    $cursor = $CONN->executeQuery('projectDB.Teams',$q);
    foreach($cursor as $team) {
        $teams[]=$team;
    }
    echo json_encode($teams);
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='createTeam')){
    $teamID = generateUTID($CONN);
    try {
    
        $bulk = new Mongo\BulkWrite;
        $bulk->insert(["teamID"=>$teamID,"teamName"=>$_POST['teamName']]);
        $res = $CONN->executeBulkWrite('projectDB.Teams', $bulk);

        if(isset($_POST['employees'])){
            foreach($_POST['employees'] as $employee){
                $bulk = new Mongo\BulkWrite;
                $filter = ["employeeID"=>(int)$employee];
                $bulk->update($filter, ['$push'=>["assignedTeam"=>$teamID]], []);
                $res = $CONN->executeBulkWrite('projectDB.Employees', $bulk);
            }
        }

        if(isset($_POST['projects'])){
            foreach($_POST['projects'] as $project){
                $bulk = new Mongo\BulkWrite;
                $filter = ["projectID"=>(int)$project];
                $bulk->update($filter, ['$set'=>["assignedTeamID"=>$teamID]], []);
                $res = $CONN->executeBulkWrite('projectDB.Projects', $bulk);
            }
        }
        echo json_encode([true,null]);

    } catch(Exception $e) {
        echo json_encode([false,$e]);
    }
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='createEmployee')){
    $eID = generateUEID($CONN);
    try {

        $bulk = new Mongo\BulkWrite;
        $bulk->insert(["employeeID"=>$eID,"employeeName"=>$_POST['eName'],"employeeRole"=>$_POST['eRole'],"employeeEmail"=>$_POST['eEmail'],"assignedTeam"=> isset($_POST['eTeams']) ? $_POST['eTeams'] : []]);
        $res = $CONN->executeBulkWrite('projectDB.Employees', $bulk);
        echo json_encode([true,null]);

    } catch(Exception $e) {
        echo json_encode([false,$e]);
    }
}

function generateUTID($CONN){
    $isUnique = false;
    while ($isUnique==false){
        $teamID = uniqid();
        $filter = ["teamID"=>$teamID];
        $q = new Mongo\Query($filter,[]);
        $teamSel = $CONN->executeQuery('projectDB.Teams',$q);
        $foundTeams=[];
        foreach($teamSel as $team){$foundTeams[]=$team;}
        if(empty($foundTeams)){$isUnique=true;}
    }
    return $teamID;
}

function generateUEID($CONN){
    $isUnique = false;
    while ($isUnique==false){
        $eID = uniqid();
        $filter = ["teamID"=>$eID];
        $q = new Mongo\Query($filter,[]);
        $eSel = $CONN->executeQuery('projectDB.Employees',$q);
        $foundEmployees=[];
        foreach($eSel as $e){$foundEmployees[]=$e;}
        if(empty($foundEmployees)){$isUnique=true;}
    }
    return $eID;
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='addEmployee')){
    try {
        $teamID = $_POST['teamID'];
        foreach ($_POST['assignedEmployees'] as $employee){
            $bulk = new Mongo\BulkWrite;
            $filter = ["employeeID"=>$employee];
            $bulk->update($filter, ['$push'=>["assignedTeam"=>$teamID]], []);
            $res = $CONN->executeBulkWrite('projectDB.Employees', $bulk);
        }
        echo json_encode([true,null]);
    } catch(Throwable $e) {
        echo json_encode([false,$e]);
    }
}

?>