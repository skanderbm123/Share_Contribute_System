<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username']))
    if($_SESSION["username"]!=null && $_SESSION['isAdmin'] == 1){

        $result = $db->query("select ID, name,Case When true then 1 end as isRegistered,Case when true then 1 else 0 end as paid from events where isDeleted=0 order by name Asc");
        $allInfo = array();

        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
        }
    }else{if($_SESSION["username"]!=null){
        $userID = $_SESSION["usernameId"];
        $result = $db->query("select 
                                e.ID,
                                e.name,
                                case
                                    when e.id in (select eventID from eventparticipants where userID = ${userID}) then 1
                                    when e.id in (select eventID from eventrequest where userID = ${userID}) then 2
                                    else 0
                                end as isRegistered,
                                case 
                                    when 
                                    e.id in (select ep.eventID from eventpaid ep where ep.eventID = e.id AND ep.userID = ${userID} AND ep.status = 'approved') then 1
                                    else 0
                                end as paid
                                from events as e 
                                inner join eventparticipants as ev
                                on ev.eventID = e.ID
                                where e.isDeleted=0 and ev.userID = ${userID} order by e.name Asc");
            $allInfo = array();

            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1] = $allInfo;
            }
        }

    }
    echo json_encode($arrayInfo);
?>