<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    $db->getLast4Series();
    
    
} else echo "Error: Database connection";

?>