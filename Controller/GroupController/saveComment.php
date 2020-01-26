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
        $groupID = $_POST['groupId'];

        if($id == "" || $comment == ""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into commentpostgroup(userID,postID,comment,date) values(".$_SESSION['usernameId'].",".$id.",'".$comment."',NOW())");

        $result = $db->query("select p.ID,u.name,p.type,p.date,pt.content from postgroup as p  inner join posttexttogroup as pt on pt.postID = p.ID
                                inner join users as u on u.id = p.userID where pt.groupID = ".$groupID." order by p.date desc");
        
            $allInfo = array();
            
            if($result){
                while($row = $result->fetch_assoc()){
                    $allCommentInfo = array();
                    $result2 = $db->query("Select u.name,c.comment,c.date from commentpostgroup as c inner join users as u on u.ID = c.userID where c.postID = ".$row['ID']."");
                    while($row2 = $result2->fetch_assoc()){
                        $allCommentInfo[] = $row2;
                    }
                    $row['children'] = $allCommentInfo;
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1]['groupPostContent'] = $allInfo;
            }

            $result = $db->query("select 
            CASE 
            when (u.isAdmin = 1) then 'All'
            when (u.isAdmin = 0 and u.id in (select userID from accgroup where groupID = ".$groupID.")) then (select TypeRef from acctype where ID = ae.access)
            end as access
            from users as u
            left join accgroup as ae on u.id= ae.userID
            left join acctype as aty on aty.ID = ae.access 
            where (u.isAdmin = 1 or ae.groupID =".$groupID.") and u.id =".$_SESSION['usernameId']);
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