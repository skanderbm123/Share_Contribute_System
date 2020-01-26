<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $allInfo= array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username'])){ 
    if($_SESSION["username"] != null){

        $result = $db->query("select name from groups where isDeleted=0 and ID in 
                            (select groupID from groupparticipants where userID=".$_SESSION['usernameId'].") ");
        
        $allInfo = array();

        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1]['groupsParticipating'] = $allInfo;
        }

        $result = $db->query("select name from groups where isDeleted=0 and managerID=".$_SESSION['usernameId']." ");
        
        $allInfo = array();

        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1]['myGroups'] = $allInfo;
        }

    }
}
echo json_encode($arrayInfo);
?>