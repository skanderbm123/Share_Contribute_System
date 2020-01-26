<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = true;
    if($_SESSION["username"]!=null){

        $result = $db->query("Select * from groupparticipants");
        $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $db->query("
                    INSERT 
                    INTO accgroup(userID,access,groupID)
                    VALUES(".$row['userID'].",1,".$row['groupID'].")");
                }
               
            }
        /*
        $eventID = $_POST['id'];

        $result = $db->query("update events set isDeleted=1 where id=".$eventID);
        $arrayInfo[0] = true;

     */
    }
    echo json_encode($arrayInfo);
?>