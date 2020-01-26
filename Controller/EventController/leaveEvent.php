<?php
include('../../Model/Config/db_server.php');
session_start();
$db = new DB();
$arrayInfo = array();
$allInfo= array();
$arrayInfo[0] = false;
if(isset($_SESSION['username']))
    if($_SESSION["username"] != null) {
        $eventId = $_POST['eventId'];
        $current_user_id = $_SESSION['usernameId'];

        $db->query("SET SQL_SAFE_UPDATES = 0");
        $db->query("delete from eventparticipants where userID = ".$current_user_id." and eventID = ".$eventId);
        $db->query("delete from accevent where userID = ".$current_user_id." and eventID = ".$eventId);

        $arrayInfo[0] = true;
        $arrayInfo[1] = $eventId;
        $arrayInfo[2] = $current_user_id;
    }

echo json_encode($arrayInfo);
?>


