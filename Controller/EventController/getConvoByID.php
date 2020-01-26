<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
 
    if(isset($_SESSION['username']))
    {if($_SESSION["username"]!=null){
        $idSelected = $_POST['id'];
            $result = $db->query(" select 
                                    message,
                                    CASE
                                        WHEN
                                            userID = ".$_SESSION['usernameId']."
                                        THEN 1
                                        ELSE 0
                                        END as mine
                                    from messageuser
                                    where conversationID = ".$idSelected." order by date 
                                    ");
            $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[1] = $allInfo;
            }
            $result = $db->query(" select 
                                    CASE
                                    When c.userID1 = 1 then (select name from users where ID = c.userID2)
                                    else (select name from users where ID = c.userID1)
                                    end as name
                                from conversation as c
                                    where (c.userID1 = ".$_SESSION['usernameId']." Or c.userID2 = ".$_SESSION['usernameId'].")
                                        and c.Id =  ".$idSelected."
                                    ");
            $allInfo = array();
            if($result){
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[2] = $allInfo;
            }

    }
}
    echo json_encode($arrayInfo);
?>