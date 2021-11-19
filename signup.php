<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['firstname']) &&($_POST['lastname'])&& isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        //function signUp($table, $firstname,$lastname, $email,$DOB,$phone, $password)
        if ($db->signUp("user1", $_POST['firstname'],$_POST['lastname'], $_POST['email'], $_POST['DOB'],$_POST['phone'], $_POST['password'])) {
            echo "Sign Up Success";
        } else echo "Sign up Failed";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
