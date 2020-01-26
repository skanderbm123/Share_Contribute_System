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

        if($id == ""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into conversation(userID1,userID2) values(".$_SESSION['usernameId'].",".$id.")");

        $result = $db->query(" select 
                                    c.ID,
                                    Case 
                                        when 
                                            c.userID1 = ".$_SESSION['usernameId']." then (select us.name from users as us where us.ID = c.userID2)
                                            else
                                            (select us.name from users as us where us.ID = c.userID1)
                                    end as name ,
                                    Case 
                                        when 
                                        ".$_SESSION['usernameId']." = ".$_SESSION['usernameId']." then ".$_SESSION['usernameId']."
                                    end as usernameID 
                                    from conversation as c
                                    where 
                                        c.userID1 = ".$_SESSION['usernameId']." 
                                    OR 
                                        c.userID2 = ".$_SESSION['usernameId']);
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