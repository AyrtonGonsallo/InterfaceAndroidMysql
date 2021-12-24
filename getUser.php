<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['password']) &&($_POST['email'])) {
    if ($db->dbConnect()) {
        $db->getUser($_POST['email'],$_POST['password']);
        
        
    } else echo "Error: Database connection";
}

?>