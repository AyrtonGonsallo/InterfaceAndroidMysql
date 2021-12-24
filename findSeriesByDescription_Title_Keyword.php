<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_GET['description'])) {
    $desc=$_GET['description'];
    if ($db->dbConnect()) {
        $db->findSerieByDescription($desc);
        
        
    } else echo "Error: Database connection";
}else if (isset($_GET['title'])) {
    $title=$_GET['title'];
    if ($db->dbConnect()) {
        $db->findSerieByTitle($title);
        
        
    } else echo "Error: Database connection";
} else if (isset($_GET['keyword'])) {
    $key=$_GET['keyword'];
    if ($db->dbConnect()) {
        $db->findSerieByKeyword($key);
        
        
    } else echo "Error: Database connection";
}

?>