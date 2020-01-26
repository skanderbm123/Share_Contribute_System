<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $allInfo= array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){
        $eventID = $_POST['eventID'];
        $eventAddress = $_POST['eventAddress'];
        $eventPhoneNumber = $_POST['eventPhoneNumber'];
        $eventOrg = $_POST['eventOrg'];

        if($eventAddress == "" || $eventPhoneNumber == "" || $eventOrg == ""){
            echo json_encode(false);
            return;
        }
        $db->query("update  events set address = '".$eventAddress."', phoneNumber = '".$eventPhoneNumber."', typeOfOrg = '".$eventOrg."'  where ID = ".$eventID);
        $arrayInfo[0] = true;
         }
    echo json_encode($arrayInfo);
?>