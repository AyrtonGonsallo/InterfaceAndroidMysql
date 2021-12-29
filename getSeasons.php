<?php
require "DataBase.php";
$db = new DataBase();

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (($data["sid"]!="") ) {
    if ($db->dbConnect()) {
        $db->getSeasons($data["sid"]);
        
        
    } else echo "Error: Database connection";
}



else{
    echo "parameter sid missing";
}

?>