<?php
include('../../Model/Config/db_server.php');
session_start();
$db = new DB();
$arrayInfo = array();
$allInfo= array();
$arrayInfo[0] = false;
if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){
        $userID = $_POST['userID'];
        $groupId = $_POST['groupId'];

        $db->query("SET SQL_SAFE_UPDATES = 0");
        $db->query("delete from groupparticipants where userID = ".$userID);
        $db->query("delete from accgroup where userID = ".$userID);

        $arrayInfo[0] = true;

        $result = $db->query("select 
                                    g.userID,
                                    u.name
                                    from groupparticipants as g 
                                    inner join users as u on u.id = g.userID
                                    where g.groupID =".$groupId." order by u.name Asc");
        $allInfo = array();

        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[2] = $allInfo;
        }

        $result = $db->query("Select 
                                    Case
                                    when exists(select id from users where isAdmin =1 and id=".$_SESSION['usernameId'].") then 1
                                    when exists(select ID from groups where ID =".$groupId." and managerID = ".$_SESSION['usernameId'].") then 1
                                    else 0
                                    end as canEdit
                                    
                                    from users
                                    where id =".$_SESSION['usernameId']."
                                    ");
        $allInfo = array();
        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[3]['canEdit'] = $allInfo;
        }
    }
echo json_encode($arrayInfo);
?>


