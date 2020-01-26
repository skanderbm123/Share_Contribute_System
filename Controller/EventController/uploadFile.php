<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $allInfo= array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){
        //for image dont add videos in it
        $os = array("image/png", "image/jpeg");
        
        $eventId= $_POST["eventId"];
        $uploads_dir = '../../Files/Events/'.$eventId;
        if($_FILES["file"]["error"] == 0 && in_array($_FILES["file"]["type"],$os)){

            $tmp_name = $_FILES["file"]["tmp_name"];

            $name = basename($_FILES["file"]["name"]);
            $direction ="$uploads_dir/$name";
            
                move_uploaded_file($tmp_name, $direction);
                
                if(in_array($_FILES["file"]["type"],$os)){
                    $db->query("insert into postevent(userID,type,date)values(".$_SESSION["usernameId"].",'Image', NOW())");
                    $id_inserted = $db->getLastInsertedId();
                    $db->query("insert into postelementtoevent(postID,eventID,pathOfFile)values(".$id_inserted.",".$eventId.",'".$direction."')");
                }
            }
            $result = $db->query("
                    select pe.ID,u.name,pe.type,pe.date,pt.content,pet.pathOfFile from postevent as pe left join  posttexttoevent as pt on pt.postID = pe.Id 
                    left join postelementtoevent as pet on pet.postID = pe.ID 
                    inner join users as u on u.id = pe.userID where pet.eventID = ".$eventId." or pt.eventID = ".$eventId." order by pe.date desc");
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
            $arrayInfo[1] = $allInfo;
            }

            $result = $db->query("select 
            CASE 
            when (u.isAdmin = 1) then 'All'
            when (u.isAdmin = 0 and u.id in (select userID from accevent where eventID = ".$eventId.")) then (select TypeRef from acctype where ID = ae.access)
            end as access
            from users as u
            left join accevent as ae on u.id= ae.userID
            left join acctype as aty on aty.ID = ae.access 
            where (u.isAdmin = 1 or ae.eventID =".$eventId.") and u.id =".$_SESSION['usernameId']);
            $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;//on check ca apres
                }
                $arrayInfo[2] = $allInfo;
            }
    }
    echo json_encode($arrayInfo);
?>