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
        $eventId = $_POST['eventId'];
        $name = $_POST['name'];

        if($id == "" || $eventId == ""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into eventparticipants(userID,eventID) values(".$id.",".$eventId.")");
        $db->query("insert into accevent(userID,access,eventID) values(".$id.",1,".$eventId.")");

        $result = $db->query("  select 
                                u.ID, 
                                u.name,
                                Case 
                                    when u.ID in (select userId from eventparticipants where eventID = ".$eventId.") then 1
                                    else 0
                                end as isRegistered
                             from users as u where name like '%".$name."%'");
        $allInfo = array();
        if($result){
            
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
        }
        $result = $db->query("select 
                                    e.userID,
                                    u.name
                                    from eventparticipants as e 
                                    inner join users as u on u.id = e.userID
                                    where e.eventID =".$eventId." order by u.name Asc");
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
                                    when exists(select ID from events where isDeleted=0 and ID =".$eventId." and managerID = ".$_SESSION['usernameId'].") then 1
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