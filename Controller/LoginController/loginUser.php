<?php
    include('../../Model/Config/db_server.php');
    //session_start();
    $db = new DB();
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($username == "" || $password == ""){
        echo json_encode(false);
    }
        
    $result = $db->query("Select * from users where username='".$username."' AND password= '".$password."'");
    $row = $result->fetch_assoc();
    $arr = array();
    // if query returns 1 value

    if($row!=null){
    $arr[0] = true;
    $arr[1] = $row['username'];
    $_SESSION['usernameId'] = $row['Id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['isAdmin'] = $row['isAdmin'];
    }
    echo json_encode($arr);
?>