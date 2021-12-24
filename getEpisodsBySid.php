<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_GET['sid'])) {
    $sid=$_GET['sid'];
    if ($db->dbConnect()) {
        $db->getEpisodsBySid($sid);
        
        
    } else echo "Error: Database connection";
}

?>