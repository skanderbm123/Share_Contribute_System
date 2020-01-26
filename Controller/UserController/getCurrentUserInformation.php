<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayUserInfo=array();
    $arrayUserInfo[0] = false;
    if(isset($_SESSION['username']))
    if($_SESSION["username"]!=null){
        
    $result = $db->query("Select * from users where id='".$_SESSION["usernameId"]."'");

        if($result != null){
            $row = $result->fetch_assoc();
            // if query returns 1 value

            if($row!=null){
                $arrayUserInfo[0] = true;
                $arrayUserInfo[1] = $row;
            }
        }       
    }

    echo json_encode($arrayUserInfo);

?>