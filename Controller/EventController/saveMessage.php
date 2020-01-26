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
        $message = $_POST['message'];

        if($id == "" || $message == ""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into messageuser(userID,message,conversationID,date) values(".$_SESSION['usernameId'].",'".$message."',".$id.",NOW())");

        $result = $db->query(" select 
                                    message,
                                    CASE
                                        WHEN
                                            userID = ".$_SESSION['usernameId']."
                                        THEN 1
                                        ELSE 0
                                        END as mine
                                    from messageuser
                                    where conversationID = ".$id." order by date 
                                    ");
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