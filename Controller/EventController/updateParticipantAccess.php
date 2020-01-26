<?php
include('../../Model/Config/db_server.php');
session_start();
$db = new DB();
$arrayInfo = array();
$allInfo= array();
$arrayInfo[0] = false;
if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){
        $eventId = $_POST['eventId'];
        $access = $_POST['access'];
        $userID = $_POST['userID'];

        $db->query(" update accevent set access = (select ID from acctype where TypeRef ='".$access."') where userID =".$userID." and eventID = ".$eventId);
        

        $arrayInfo[0] = true;

    }
echo json_encode($arrayInfo);
?>