<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
 
    if(isset($_SESSION['username']))
    {if($_SESSION["username"]!=null){

        $idSelected = $_POST['id'];
            $result = $db->query("select 
                                    e.ID,
                                    e.name
                                    from events as e 
                                    where e.isDeleted=0 and e.id =".$idSelected." order by e.name Asc");
            $allInfo = array();

            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1]['eventheader'] = $allInfo;
            }

            $result = $db->query("select 
                                    e.userID,
                                    u.name
                                    from eventparticipants as e 
                                    inner join users as u on u.id = e.userID
                                    where e.eventID =".$idSelected." order by u.name Asc");
            $allInfo = array();

            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1]['eventParticipant'] = $allInfo;
            }

            $result = $db->query("select 
                                    e.ID,
                                    g.name
                                    from groups as g 
                                    inner join events as e on e.ID = g.eventID
                                    where e.isDeleted=0 and g.isDeleted=0 and e.ID =".$idSelected." order by g.name Asc");
            $allInfo = array();

            if($result){
                 while($row = $result->fetch_assoc()){
                     $allInfo[] = $row;
                     }
                 $arrayInfo[1]['eventGroup'] = $allInfo;
            }

            $result = $db->query("select * 
                                from users 
                                where id in 
                                    (select userID 
                                    from eventparticipants
                                    where eventID=".$idSelected.");");
            $allInfo = array();

            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1]['allUsersOfEvent'] = $allInfo;
            }

             $result = $db->query("
                                select pe.ID,u.name,pe.type,pe.date,pt.content,pet.pathOfFile  from postevent as pe left join  posttexttoevent as pt on pt.postID = pe.Id 
                                left join postelementtoevent as pet on pet.postID = pe.ID 
                                inner join users as u on u.id = pe.userID where pet.eventID = ".$idSelected." or pt.eventID = ".$idSelected." order by pe.date desc");
            $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $allCommentInfo = array();
                    $result2 = $db->query("Select u.name,c.comment,c.date from commentpostevent as c inner join users as u on u.ID = c.userID where c.postID = ".$row['ID']."");
                    while($row2 = $result2->fetch_assoc()){
                        $allCommentInfo[] = $row2;
                    }
                    $row['children'] = $allCommentInfo;
                    $allInfo[] = $row;
                }
                $arrayInfo[1]['eventPostContent'] = $allInfo;
            }

            $result = $db->query("select 
                                    CASE 
                                    when (u.isAdmin = 1) then 'All'
                                    when (u.isAdmin = 0 and u.id in (select userID from accevent where eventID = ".$idSelected.")) then (select TypeRef from acctype where ID = ae.access)
                                    end as access
                                    from users as u
                                    left join accevent as ae on u.id= ae.userID
                                    left join acctype as aty on aty.ID = ae.access 
                                    where (u.isAdmin = 1 or ae.eventID =".$idSelected.") and u.id =".$_SESSION['usernameId']);
            $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[1]['access'] = $allInfo;
            }

            $result = $db->query("Select 
                                    Case
                                    when exists(select id from users where isAdmin =1 and id=".$_SESSION['usernameId'].") then 1
                                    when exists(select ID from events where isDeleted=0 and ID =".$idSelected." and managerID = ".$_SESSION['usernameId'].") then 1
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
                $arrayInfo[0] = true;
                $arrayInfo[1]['canEdit'] = $allInfo;
            }

            $result = $db->query("select managerID from events where isDeleted=0 and ID=".$idSelected);
            $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1]['eventManager'] = $allInfo;
                $arrayInfo[1]['loggedInUserId'] = $_SESSION['usernameId'];
            }            

        }

    }
    echo json_encode($arrayInfo);
?>