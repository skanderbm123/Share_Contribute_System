<?php

include('../../Model/Config/db_server.php');
require_once '../../vendor/autoload.php';

session_start();
$db = new DB();
$arrayInfo = array();
$allInfo= array();
$arrayInfo[0] = false;



$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))
  ->setUsername('sharecontributesystem@gmail.com')
  ->setPassword('password1!#')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);


if(isset($_SESSION['username']))
    if($_SESSION["username"] != null){
        $groupId = $_POST['groupId'];
        $name = $_POST['name'];
        if($groupId == ""){
            echo json_encode(false);
            return;
        }

        $db->query("insert into grouprequest(userID,groupID) values(".$_SESSION["usernameId"].",".$groupId.")");

        $result = $db->query("select 
                                    g.name,
                                    g.ID,
                                    e.name as eventName,
                                    case
                                    when g.ID in (select groupID from groupparticipants where userID = ".$_SESSION['usernameId'].") then 1
                                    when g.ID in (select groupID from grouprequest where userID = ".$_SESSION["usernameId"].") then 2
                                    else 0
                                    end as isRegistered
                                    from groups as g 
                                    left join events as e on e.ID=g.eventID
                                    where g.isDeleted=0 and e.isDeleted=0 and g.id in (select gp.groupID from groupparticipants as gp where gp.userID =".$_SESSION['usernameId']." and g.name like '%".$name."%' order by g.name Asc)");
        $allInfo = array();

        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
            $arrayInfo[2] = "manne";
        }

        $result = $db->query("select g.ID,g.name,e.name as eventName,
                                    case
                                    when g.ID in (select groupID from groupparticipants where userID = ".$_SESSION['usernameId'].") then 1
                                    when g.ID in (select groupID from grouprequest where userID = ".$_SESSION["usernameId"].") then 2
                                    else 0
                                    end as isRegistered
                                     from groups as g 
                                     left join events as e on e.ID = g.eventID
                                     where g.isDeleted=0 and e.isDeleted=0 and eventID in 
                                     (select e.Id 
                                        from eventparticipants as ep 
                                        inner join events as e on e.Id = ep.eventID 
                                        where e.isDeleted=0 and ep.userid=".$_SESSION['usernameId'].")  AND NOT g.ID in 
                                        (select gp2.groupID 
                                            from groupparticipants as gp2 
                                                   where gp2.userID) AND  g.name like '%".$name."%' order by g.name Asc");

        if($result){
            while($row = $result->fetch_assoc()){
                $allInfo[] = $row;
            }
            $arrayInfo[0] = true;
            $arrayInfo[1] = $allInfo;
           
        }

        $result = $db->query("select u.name as username,u.email, g.name as groupname 
        from groups as g left join  users as u on u.ID = g.managerID where g.id= (select id from groups where id='".$groupId."')");

        if($result){
            $row = $result->fetch_assoc();
           
        $body = ' 
        <html> 
        <body> 
            <h1>Group request alert!</h1> 
            <p>Hello '.$row['username'].' , you are receving this message because a user is currently requesting to enter the group called : '.$row['groupname'].'<br />
            Please connect into the portal to accept or refuse the request</p>
                <a href="https://mrc353.encs.concordia.ca/">Share Contribute System</a>
                
            </table> 
        </body> 
        </html>'; 

            $message = (new Swift_Message('Group Request for '.$row['groupname']))
            ->setFrom(['sharecontributesystem@gmail.com' => 'Share Contribute System'])
            ->setTo(['skander96@hotmail.com',$row['email']])
            ->setBody($body)
                            ;
            // Send the message
           $message->setContentType("text/html");
           $resultMail = $mailer->send($message);
        } 
     

    }
echo json_encode($arrayInfo);