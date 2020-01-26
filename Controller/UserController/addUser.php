<?php
include('../../Model/Config/db_server.php');
session_start();
$db = new DB();
$arrayInfo = array();
$allInfo= array();
$arrayInfo[0] = false;
if(isset($_SESSION['username']))
    if($_SESSION["username"] != null && $_SESSION['isAdmin'] == 1){
        $name = $_POST['name'];
        $userDOB = $_POST['userDOB'];
        $userEmail = $_POST['email'];
        $userName = $_POST['userName'];
        $userPassword = $_POST['password'];
        $isAdmin = $_POST['isAdmin'];

        if($name == "" || $userDOB == ""|| $userEmail == ""|| $userName == "" || $userPassword == ""){
            echo json_encode(false);
            return;
        }
        // Check if isAdmin checked
        if ($isAdmin == 1) {
            $db->query("insert into users(name,password,birth,email,isAdmin,userName) values('".$name."','".$userPassword."','".$userDOB."','".$userEmail."',1,'".$userName."')");
        } else {
            $db->query("insert into users(name,password,birth,email,isAdmin,userName) values('".$name."','".$userPassword."','".$userDOB."','".$userEmail."',0,'".$userName."')");
        }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $name;
    }

echo json_encode($arrayInfo);
?>