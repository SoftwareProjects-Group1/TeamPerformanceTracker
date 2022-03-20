<?php
session_start();
if(isset($_POST) && isset($_POST['action']) && $_POST['action'] == "logout"){
    unset($_SESSION['loggedIN']);
    unset($_SESSION['userRole']);
    unset($_SESSION['userFname']);
    unset($_SESSION['userSname']);
    unset($_SESSION['userUname']);
}
?>