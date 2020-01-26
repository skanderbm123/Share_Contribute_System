<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username'])){
        $name = $_POST['name'];
        $result = $db->query("select ID, name from users where name like '%".$name."%'");
        $allInfo = array();
        if($result){
            
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
            // Checking if the user is an admin or not.
            if($_SESSION['isAdmin'] == 1){
                $arrayInfo[2] = true;
            } else {
                $arrayInfo[2] = false;
            }
        }
    }
    echo json_encode($arrayInfo);
?>