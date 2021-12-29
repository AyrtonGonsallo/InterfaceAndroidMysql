<?php
require "DataBase.php";
$db = new DataBase();

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (($data["sid"]!="" &&$data["season"]!="") ) {
    if ($db->dbConnect()) {
        $db->getEpisods($data["sid"],$data["season"]);
        
        
    } else echo "Error: Database connection";
}



else{
    echo "parameter sid missing";
}

?>