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
        $comment = $_POST['comment'];
        $eventID = $_POST['eventId'];

        if($id == "" || $comment == ""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into commentpostevent(userID,postID,comment,date) values(".$_SESSION['usernameId'].",".$id.",'".$comment."',NOW())");

        $result = $db->query("
        select pe.ID,u.name,pe.type,pe.date,pt.content,pet.pathOfFile  from postevent as pe left join  posttexttoevent as pt on pt.postID = pe.Id 
                    left join postelementtoevent as pet on pet.postID = pe.ID 
                    inner join users as u on u.id = pe.userID where pet.eventID = ".$eventID." or pt.eventID = ".$eventID." order by pe.date desc");
        
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
                $arrayInfo[0] = true;
                $arrayInfo[1]['eventPostContent'] = $allInfo;
            }
            $result = $db->query("select 
                                    CASE 
                                    when (u.isAdmin = 1) then 'All'
                                    when (u.isAdmin = 0 and u.id in (select userID from accevent where eventID = ".$eventID.")) then (select TypeRef from acctype where ID = ae.access)
                                    end as access
                                    from users as u
                                    left join accevent as ae on u.id= ae.userID
                                    left join acctype as aty on aty.ID = ae.access 
                                    where (u.isAdmin = 1 or ae.eventID =".$eventID.") and u.id =".$_SESSION['usernameId']);
            $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[1]['access'] = $allInfo;
            }
    }
    echo json_encode($arrayInfo);
?>