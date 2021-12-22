<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    $movies=$db->getLast4Movies();
    
    
} else echo "Error: Database connection";

?>
