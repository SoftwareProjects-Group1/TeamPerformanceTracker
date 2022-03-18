<?php
function verify(){
if (!isset($_POST['uname']) or !isset($_POST['pwd'])) {
    return ;  // <-- return null;
}

$db = new Mongo('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');

$stmt = $db->prepare('SELECT Username, Password, First_Name, Last_Name, Email_Address, Role FROM Users WHERE Username=:uname AND Password=:pwd');
$stmt->bindParam(':uname', $_POST['uname'], SQLITE3_TEXT);
$stmt->bindParam(':pwd', $_POST['pwd'], SQLITE3_TEXT);

$result = $stmt->execute();

$rows_array = [];
while ($row=$result->fetchArray())
{
    $rows_array[]=$row;
}
return $rows_array;


}

?>