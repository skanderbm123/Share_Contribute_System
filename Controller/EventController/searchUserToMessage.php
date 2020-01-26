<?php
    include('../../Model/Config/db_server.php');
    session_start();
    $db = new DB();
    $arrayInfo = array();
    $arrayInfo[0] = false;
 
    if(isset($_SESSION['username']))
    {if($_SESSION["username"]!=null){
        $arrayInfo[0] = "YANISI";
        $searchedName = $_POST['name'];
            $result = $db->query("select 
                                    u.name,
                                    u.ID,
                                    CASE
                                        WHEN Exists( select * from conversation where
                                                                        (userID1 ='".$_SESSION['usernameId']."' AND userID2 = u.ID)
                                                                            OR
                                                                        (userID1 = u.ID AND userID2 = '".$_SESSION['usernameId']."')
                                                                            ) Then 1 else 0
                                    end as alreadyConvo
                                    from users as u 
                                    where u.name like '%".$searchedName."%'");
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