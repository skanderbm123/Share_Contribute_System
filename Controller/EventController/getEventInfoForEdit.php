<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
 
    if(isset($_SESSION['username']))
    {if($_SESSION["username"]!=null){
        $eventId = $_POST['eventID'];
        $result = $db->query("select * from events where ID = ".$eventId);
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