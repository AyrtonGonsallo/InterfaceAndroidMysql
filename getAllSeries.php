<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    $db->getAllSeries();
    
    
} else echo "Error: Database connection";

?>