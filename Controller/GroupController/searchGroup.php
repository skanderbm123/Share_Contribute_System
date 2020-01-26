<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;

    if($_SESSION["username"]!=null && $_SESSION['isAdmin'] == 1){

            $name = $_POST['name'];
            $result = $db->query("select g.ID,g.name,e.name as eventName,Case When true then 1 end as isRegistered from groups as g left join events as e on e.ID=g.eventID where g.isDeleted=0 and g.name like '%".$name."%' order by g.name Asc");
                
            $allInfo = array();
    
            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1] = $allInfo;
            }

            } else if($_SESSION["username"]!=null) {

            $name = $_POST['name'];
            
            $result = $db->query("select 
                                    g.name,
                                    g.ID,
                                    e.name as eventName,
                                    Case When true then 1 end as isRegistered
                                    from groups as g 
                                    left join events as e on e.ID=g.eventID
                                    where g.isDeleted=0 and e.isDeleted=0 and g.id in (select gp.groupID from groupparticipants as gp where gp.userID =".$_SESSION['usernameId']." and g.name like '%".$name."%' order by g.name Asc)");
            $allInfo = array();

            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1] = $allInfo;
            }

            $result = $db->query("select g.ID,g.name,e.name as eventName,Case When true then 0 end as isRegistered 
                                     from groups as g 
                                     left join events as e on e.ID = g.eventID
                                     where g.isDeleted=0 and e.isDeleted=0 and eventID in 
                                     (select e.Id 
                                        from eventparticipants as ep 
                                        inner join events as e on e.Id = ep.eventID 
                                        where e.isDeleted=0 and ep.userid=".$_SESSION['usernameId'].")  AND NOT g.ID in 
                                        (select gp2.groupID 
                                            from groupparticipants as gp2 
                                                   where gp2.userID) AND  g.name like '%".$name."%' order by g.name Asc");

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