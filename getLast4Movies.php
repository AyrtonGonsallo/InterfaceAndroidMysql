<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    $db->getLast4Movies();
    
    
} else echo "Error: Database connection";

?>
