<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $allInfo= array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){
        $id = $_POST['id'];
        $groupId = $_POST['groupId'];

        if($id == "" || $groupId == ""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into groupparticipants(userID,groupID) values(".$id.",".$groupId.")");
        $db->query("insert into accgroup(userID,access,groupID) values(".$id.",1,".$groupId.")");

        $result = $db->query("select u.ID, u.name,
                        Case 
                        when u.ID in (select userId from groupparticipants where groupID = ".$groupId.") then 1
                        else 0
                    end as isRegistered

                    from eventparticipants as ep inner join events as e on ep.eventID = e.ID
                    inner join groups as g on e.ID = g.eventID
                    inner join users as u on u.ID = ep.userID where g.ID = ".$groupId." group by u.ID;");
        $allInfo = array();
        if($result){
            
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
        }
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