<?php
    session_start();
    include('../../Model/Config/db_server.php');
    require_once '../../vendor/autoload.php';



    
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))
->setUsername('sharecontributesystem@gmail.com')
->setPassword('password1!#')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_SESSION['username'])){
            //set variables
            $db = new DB();
            $arrayInfo = array();
            $allInfo= array();
            $arrayInfo[0] = false;
            $eventId = $_POST['eventId'];
            $name = $_POST['name'];

            if($eventId == "" || $name == ""){
                echo json_encode(false);
                return;
            }
            $db->query("insert into eventrequest(userID,eventID) values(".$_SESSION["usernameId"].",".$eventId.")");
            $result = $db->query("select 
                                e.id as ID,
                                e.name as name,
                                case
                                    when e.id in (select eventID from eventparticipants where userID = ".$_SESSION['usernameId'].") then 1
                                    when e.id in (select eventID from eventrequest where userID = ".$_SESSION["usernameId"].") then 2
                                    else 0
                                    end as isRegistered
                                from events as e where isDeleted=0 and name like '%".$name."%'");
            $allInfo = array();
            if($result){
                
                while($row = $result->fetch_assoc()){
                    $allInfo[] = $row;
                }
                $arrayInfo[0] = true;
                $arrayInfo[1] = $allInfo;
            }


            $result = $db->query("select u.name as username,u.email, e.name as eventname 
            from events as e left join  users as u on u.ID = e.managerID where e.id= (select id from events where id=".$eventId.")");
    
            if($result){
                $row = $result->fetch_assoc();
               
            $body = ' 
            <html> 
            <body> 
                <h1>Event request alert!</h1> 
                <p>Hello '.$row['username'].' , you are receving this message because a user is currently requesting to enter the event called : '.$row['eventname'].'<br />
                Please connect into the portal to accept or refuse the request</p>
                    <a href="https://mrc353.encs.concordia.ca/">Share Contribute System</a>
                    
                </table> 
            </body> 
            </html>'; 
    
                $message = (new Swift_Message('Event Request for '.$row['eventname']))
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
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        header("Location: ..\..\View\Dashboard\dashboard.php");
    }
?>