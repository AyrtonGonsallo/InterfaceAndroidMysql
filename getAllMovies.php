<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
    $db->getAllMovies();
    
    
} else echo "Error: Database connection";

?>