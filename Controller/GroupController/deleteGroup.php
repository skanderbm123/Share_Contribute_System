<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
    if($_SESSION["username"]!=null){
        $groupID = $_POST['id'];

        $result = $db->query("update groups set isDeleted=1 where id=".$groupID);
        $arrayInfo[0] = true;

     
    }
    echo json_encode($arrayInfo);
?>