<?php
require "DataBase.php";
$db = new DataBase();

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (($data["mid"]!="") ) {
    if ($db->dbConnect()) {
        $db->getMovieComment($data["mid"]);
        
        
    } else echo "Error: Database connection";
}
else if (($data["sid"]!="") ) {
    if ($db->dbConnect()) {
        $db->getSerieComment($data["sid"]);
        
        
    } else echo "Error: Database connection";
}


else{
    echo "parameters email or password missing";
}

?>