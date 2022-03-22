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
    $filter = ["teamID"=>(int)$teamID];
    $bulk->delete($filter,['limit' => 1]);
    $res = $CONN->executeBulkWrite('projectDB.Teams', $bulk);

    //Unassign Employees from the team
    $bulk = new Mongo\BulkWrite;
    $filter = ["assignedTeam"=>(int)$teamID];
    $bulk->update($filter, ['$set'=>["assignedTeam"=>null]], []);
    $res = $CONN->executeBulkWrite('projectDB.Employees', $bulk);

    //Unassign Projects from the team
    $bulk = new Mongo\BulkWrite;
    $filter = ["assignedTeamID"=>(int)$teamID];
    $bulk->update($filter, ['$set'=>["assignedTeamID"=>0]], []);
    $res = $CONN->executeBulkWrite('projectDB.Projects', $bulk);

    echo "true";
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

?>