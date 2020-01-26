<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username'])){
        $name = $_POST['name'];
        $id = $_POST['id'];
        $result = $db->query("  select 
                                u.ID, 
                                u.name,
                                Case 
                                    when u.ID in (select userId from eventparticipants where eventID = ".$id.") then 1
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
    }
    echo json_encode($arrayInfo);
?>