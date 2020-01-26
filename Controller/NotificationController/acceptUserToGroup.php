<?php
include('../../Model/Config/db_server.php');
session_start();
$db = new DB();
$arrayInfo = array();
$arrayInfo[0] = false;
if(isset($_SESSION['username'])){
    $userId = $_POST['userId'];
    $groupId = $_POST['groupId'];
    $db->query("insert into accgroup(userID,access,groupID) values(".$userId.",1,".$groupId.")");
    $result = $db->query("insert into groupparticipants(userID,groupID) values(".$userId.",".$groupId.") ");
    $result = $db->query("delete from grouprequest where userID = ".$userId." and groupID = ".$groupId);
    /*                GROUP REQUESTS                      */
    $result = $db->query("  select 
                                u.ID as userID, 
                                u.name,
                                g.id as groupID,
                                g.name as groupname
                            from grouprequest gr
                            inner join groups as g on g.id = gr.groupID 
                            inner join users as u on u.ID = gr.userID
                            where g.managerID = ".$_SESSION['usernameId']);
    $allInfo = array();
    if($result){

        while($row = $result->fetch_assoc()){
            $allInfo[] = $row;
        }
        $arrayInfo[0] = true;
        $arrayInfo[1] = $allInfo;
    }
    /*                EVENT REQUESTS                      */
    $result = $db->query("  select 
                                u.ID as userID, 
                                u.name,
                                e.ID as eventID,
                                e.name as eventname
                            from eventrequest er
                            inner join events as e on e.ID = er.eventID 
                            inner join users as u on u.ID = er.userID 
                            where e.managerID = ".$_SESSION['usernameId']);
    $allInfo = array();
    if($result){

        while($row = $result->fetch_assoc()){
            $allInfo[] = $row;
        }
        $arrayInfo[0] = true;
        $arrayInfo[2] = $allInfo;
    }
}
echo json_encode($arrayInfo);
?>