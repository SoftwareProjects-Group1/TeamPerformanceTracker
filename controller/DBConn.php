<?php
if(!isset($GLOBALS['DBConn'])){
    connect();
} else {
    try {
        $listdatabases = new MongoDB\Driver\Command(["listCollections" => 1]);
        $res = $GLOBALS['DBConn']->executeCommand("projectDB", $listdatabases);
    }
    catch (Throwable $e){
        connect();
    }
}
function connect() {
    try {
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        $listdatabases = new MongoDB\Driver\Command(["listCollections" => 1]);
        $res = $m->executeCommand("projectDB", $listdatabases);
        $GLOBALS['DBConnStatus'] = true;
        $GLOBALS['DBConn'] = $m;
    }
    
    catch (Throwable $e) {
        $GLOBALS['DBConnStatus'] = false;
    }
}
?>