<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
    if($_SESSION["username"]!=null && $_SESSION['isAdmin'] == 1){
        $name = $_POST['name'];
        $result = $db->query("select ID, name,Case When true then 1 end as isRegistered,Case when true then 1 else 0 end as paid from events where isDeleted=0 and name like '%".$name."%' order by name Asc");
        $allInfo = array();

        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
        }
    }
    else if(isset($_SESSION['username'])){
        $name = $_POST['name'];
        $userID = $_SESSION["usernameId"];
        
        $result = $db->query("select 
                            e.id as ID,
                            e.name as name,
                            case
                                when e.id in (select eventID from eventparticipants where userID = ${userID}) then 1 
                                when e.id in (select eventID from eventrequest where userID = ${userID}) then 2
                                else 0
                                end as isRegistered,
                            case 
                                when e.id in (select ep.eventID from eventpaid ep 
                                    where ep.eventID = e.id AND ep.userID = ${userID} AND ep.status = 'approved') 
                                then 1
                                else 0
                            end as paid
                            from events as e where isDeleted=0 and name like '%".$name."%'");
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