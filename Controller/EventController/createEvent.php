<?php
include('../../Model/Config/db_server.php');
session_start();
$db = new DB();
$arrayInfo = array();
$allInfo= array();
$arrayInfo[0] = false;
if(isset($_SESSION['username']))
    if($_SESSION["username"] != null && $_SESSION['isAdmin'] == 1){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];

        if($name == "" || $address == ""|| $phone == ""|| $type == ""){
            echo json_encode(false);
            return;
        }
        $db->query("insert into events(name,managerID,address,phoneNumber,isActive,typeOfOrg) values('".$name."','".$_SESSION['usernameId']."','".$address."','".$phone."',1,'".$type."')");
        $result2 = $db->getLastInsertedId();
        if($result2){
                mkdir("../../Files/Events/".$result2, 0700);
        }
        $db->query("insert into accevent values(".$_SESSION['usernameId'].",(select ID from acctype where Type = 'All'),".$result2." );");
        $result = $db->query("select ID, name,Case When true then 1 end as isRegistered,
                            case 
                                when true then 1
                                else 0
                            end as paid from events where isDeleted=0 order by ID desc");
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