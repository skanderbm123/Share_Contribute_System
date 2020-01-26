<?php
include('../../Model/Config/db_server.php');
session_start();
$db = new DB();
$arrayInfo = array();
$allInfo= array();
$arrayInfo[0] = false;
if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){
        $groupId = $_POST['groupId'];
        $userId = $_POST['userId'];
        $result = $db->query("Select u.name,u.id as userID,t.Type from accgroup as e inner join acctype as t  on e.access = t.ID inner join users as u on u.id = e.userID  where e.groupID = ".$groupId." and userID = ".$userId."");
        $allInfo = array();
        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
        }
    }
echo json_encode($arrayInfo);
?>