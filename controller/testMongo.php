<?php
try {
    $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
    $listdatabases = new MongoDB\Driver\Command(["listCollections" => 1]);
    $res = $m->executeCommand("projectDB", $listdatabases);
    foreach($res as $team) {
        var_dump($team);
    }
}
catch (Throwable $e) {
    var_dump($e);
}
?>