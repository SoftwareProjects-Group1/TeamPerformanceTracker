<?php

function verify(){
try {



if (!isset($_POST['uname']) or !isset($_POST['pwd'])) {
    return ;  // <-- return null;
}

$username = $_POST['uname'];
$password = $_POST['pwd'];

$conn = new Mongo('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
$db = $conn->test;
$collection = $db->items;

$user = $db->$collection->findOne(array('Username'=> 'user1', 'Password'=> 'pass1'));

$rows_array = [];

foreach ($user as $obj) {
    $Role = $obj['Username'];
    }


    $conn->close();


    return $Role;



}catch (MongoConnectionException $e) {
    die('Error connecting to MongoDB server');
} catch (MongoException $e) {
    die('Error: ' . $e->getMessage());
}

}



?>