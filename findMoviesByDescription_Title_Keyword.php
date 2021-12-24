<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_GET['description'])) {
    $desc=$_GET['description'];
    if ($db->dbConnect()) {
        $db->findMovieByDescription($desc);
        
        
    } else echo "Error: Database connection";
}else if (isset($_GET['title'])) {
    $title=$_GET['title'];
    if ($db->dbConnect()) {
        $db->findMovieByTitle($title);
        
        
    } else echo "Error: Database connection";
} else if (isset($_GET['keyword'])) {
    $key=$_GET['keyword'];
    if ($db->dbConnect()) {
        $db->findMovieByKeyword($key);
        
        
    } else echo "Error: Database connection";
}

?>