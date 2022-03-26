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
    
    $q = new Mongo\Query([],[]);
    
    $cursor = $CONN->executeQuery('projectDB.Employees',$q);
    foreach($cursor as $employee) {
        $employees[]=$employee;
    }
    
    $cursor = $CONN->executeQuery('projectDB.Teams',$q);
    foreach($cursor as $employee) {
        $teams[]=$employee;
    } 
       
    echo json_encode(["teams"=>$teams,"employees"=>$employees]);
}

if(isset($_POST) && (isset($_POST['action']) && $_POST['action']=='deleteEmployee')){
    $employeeID=$_POST['employeeID'];
}

?>