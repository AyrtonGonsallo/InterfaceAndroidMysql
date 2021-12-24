<?php
require "DataBase.php";
$db = new DataBase();
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (($data["email"]!="") &&($data["password"]!="")) {
    if ($db->dbConnect()) {
        $db->getUser($data["email"],$data["password"]);
        
        
    } else echo "Error: Database connection";
}else{
    echo "parameters email or password missing";
}

?>