<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $allInfo= array();
    $arrayInfo[0] = false;
    $allUserID = array();

    if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){

        $name = $_POST['name'];
        $id = $_POST['id'];
        $allUserID = json_decode($_POST['userId']);
        
        if($name == "" || $id==""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into groups(name,managerID,creationDate,eventID) values('".$name."','".$_SESSION["usernameId"]."','". date('Y-m-d H:i:s')."','".$id."')");
        $result = $db->query("select ID from groups where name='".$name."' AND managerID='".$_SESSION["usernameId"]."'");

        if($result){
            
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
            
        }
        
        foreach($allUserID as $value)  {
             $db->query("insert into groupparticipants  (userID,groupID) values ('".$value."','".$arrayInfo[1][0]['ID']."')");
            }


        
        $result = $db->query("select 
                                    e.ID,
                                    g.name
                                    from groups as g 
                                    inner join events as e on e.ID = g.eventID
                                    where g.isDeleted=0 and e.isDeleted=0 and e.ID =".$id." order by g.name Asc");

        $allInfo= array();
        if($result){
            
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[2]= $allInfo;
            
        }
         

    }
    echo json_encode($arrayInfo);
?>