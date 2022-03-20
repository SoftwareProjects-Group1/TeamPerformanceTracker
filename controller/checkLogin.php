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




// function verify(){
// try {



// if (!isset($_POST['uname']) or !isset($_POST['pwd'])) {
//     return ;  // <-- return null;
// }

// $username = $_POST['uname'];
// $password = $_POST['pwd'];

// $conn = new Mongo('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
// $db = $conn->test;
// $collection = $db->items;

// $user = $db->$collection->findOne(array('Username'=> 'user1', 'Password'=> 'pass1'));

// $rows_array = [];

// foreach ($user as $obj) {
//     $Role = $obj['Username'];
//     }


//     $conn->close();


//     return $Role;



// }catch (MongoConnectionException $e) {
//     die('Error connecting to MongoDB server');
// } catch (MongoException $e) {
//     die('Error: ' . $e->getMessage());
// }

// }



?>