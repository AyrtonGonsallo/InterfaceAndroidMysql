<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['uid']) &&($_POST['text'])) {
    if ($db->dbConnect()) {
        if(isset($_POST['mid'])){
            if ($db->addMovieComment("comments", $_POST['uid'],$_POST['text'], $_POST['mid'])) {
                echo "add movie comment Success";
            } else echo "add movie comment Failed";
        }
        else if(isset($_POST['sid'])){
            if ($db->addSerieComment("comments", $_POST['uid'],$_POST['text'], $_POST['sid'])) {
                echo "add serie comment Success";
            } else echo "add serie comment Failed";
        }
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>