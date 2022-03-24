<?php
session_start();
include 'DBConn.php';
use MongoDB\Driver as Mongo;
$CONN;
if(isset($GLOBALS['DBConnStatus']) && $GLOBALS['DBConnStatus']==true){
    $CONN=$GLOBALS['DBConn'];
}

if(isset($_POST) && isset($_POST['action']) && $_POST['action'] == "checkPass"){
    $uName = $_POST['uname'];
    $pWord = $_POST['pwd'];
    $filter = ["Username"=>$uName];
    $q = new Mongo\Query($filter,[]);
    $usersSel = $CONN->executeQuery('projectDB.Users',$q);
    $foundUser="";
    foreach($usersSel as $user) {
        $foundUser=$user;
    }
    if($foundUser==""){
        unset($_SESSION['loggedIN']);
        unset($_SESSION['userRole']);
        unset($_SESSION['userFname']);
        unset($_SESSION['userSname']);
        unset($_SESSION['userUname']);
        echo json_encode([false,0]);
    }
    else{
        $foundUser = json_decode(json_encode($foundUser), true);
        $fuName=$foundUser['Username'];
        $fpWord=$foundUser['Password'];
        $fRole=$foundUser['Role'];
        if($fuName == $uName && $fpWord == $pWord){
            if($_POST["rem"]=="true"){
                if(!isset($_COOKIE['username'])){setcookie("username", $uName, time() + 3600 * 24 * 365, "/");}
                if(!isset($_COOKIE['password'])){setcookie("password", $pWord, time() + 3600 * 24 * 365, "/");}
                if(!isset($_COOKIE['checked'])){setcookie("checked", true, time() + 3600 * 24 * 365, "/");}
            } else {
                setcookie("username","",time() - 3600,"/");
                setcookie("password","",time() - 3600,"/");
                setcookie("checked","",time() - 3600,"/");
            }
            $_SESSION['loggedIN']=true;
            $_SESSION['userRole']=$fRole;
            $_SESSION['userFname']=$foundUser['First_Name'];
            $_SESSION['userSname']=$foundUser['Last_Name'];
            $_SESSION['userUname']=$fuName;
            echo json_encode([true,$fRole]);
            
        }
        else {
            unset($_SESSION['loggedIN']);
            unset($_SESSION['userRole']);
            unset($_SESSION['userFname']);
            unset($_SESSION['userSname']);
            unset($_SESSION['userUname']);
            echo json_encode([false,0]);
        }
    }
}








?>