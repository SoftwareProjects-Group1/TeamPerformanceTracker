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

?>