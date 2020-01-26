<?php
     include('../../Model/Config/db_server.php');
     session_start();
     $db = new DB();
     $arrayInfo = array();
     $arrayInfo[0] = false;
     if(isset($_SESSION['username'])){
    
     if($_SESSION["username"]!=null) {

        $idSelected = $_POST['id'];
            $result = $db->query("select * 
                                    from groups as g 
                                    left join groupparticipants as gp on gp.groupID = g.id 
                                    where g.isDeleted=0 and eventID in 
                                        (select e.Id 
                                        from eventparticipants as ep 
                                        inner join events as e on e.Id = ep.eventID 
                                        where e.isDeleted=0 and ep.userid=".$idSelected.") 
                                        OR g.ID in 
                                            (select gp2.groupID 
                                            from groupparticipants as gp2 
                                            where gp2.userID)");
            $allInfo = array();

            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1]['groupHeaders'] = $allInfo;
            }

            $result = $db->query("select 
                                    g.name,
                                    g.managerID,
                                    g.creationDate,
                                    g.eventID
                                    from groups as g 
                                    where g.isDeleted=0 and g.id in (select gp.groupID from groupparticipants as gp where gp.userID =".$idSelected.")");
            $allInfo = array();

            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1]['mygroups'] = $allInfo;
            }
        }

     }
    echo json_encode($arrayInfo);
?>