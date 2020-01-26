<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
    if(isset($_SESSION['username']))
    if($_SESSION["username"]!=null){
        $name = $_POST['name'];

        if($name == ""){
            echo json_encode(false);
            return;
        }
        
        $result = $db->query("Update users set name = '".$name."' where username = '".$_SESSION["username"]."'");
      
        if($result){
            $arrayInfo[0] =true;
        }
}
    echo json_encode($arrayInfo);
?>