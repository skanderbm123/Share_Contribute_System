<?php

include('../../Model/Config/db_server.php');
include('../../Utils/utils.php');
class PayPal{
    private $db;
    public function __construct()
    {   
        $this->db = new DB(); 
    }

    public function __destruct(){
        $this->close($this->db);
    }

    private function getData($result){
        $data = array();
        $data[0] = false;

        $rows = array();
        if($result){
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            $data[0] = true;
            $data[1] = $rows;
        }
        return $data;
    }

    public function didUserPay($userID, $eventID){
        $stmt = $this->db->prepare("select * from eventpaid where userID=? AND eventID=?");
        $stmt->bind_param("ii", $userID, $eventID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $value;
        if($result)
            $value = true;
        else
            $value = false;
        $this->close($stmt);
        return $value;
        
    }

    public function insertPaidEvent($userID, $eventID, $amount, $transactionID, $status, $invoiceID){
        $stmt = $this->db->prepare("insert into eventpaid(userID, eventID, amount, transactionID, status, invoiceID) values(?,?,?,?,?,?)");
        $stmt->bind_param("iisisi", $userID, $eventID, $amount, $transactionID, $status, $invoiceID);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function getPaidEventHistory($userID){
        $stmt = $this->db->prepare("select * from eventpaid where userID=?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $this->getData($result);
        $this->close($stmt);
        
        if($data[0])
            return $data[1];
        else
            return -1;
    
    }

    public function getEventFee($eventID){
        $yearlyCost = Utils::getYearlyCost();
        $numberOfParticipants = $this->getNumberOfParticipants($eventID);
        
        $totalNumberOfParticipants = $this->getTotalNumberOfParticipants();

        $diskSpaceFactor = Utils::getDiskUsageFactor($eventID);
        $participantsFactor = $numberOfParticipants /$totalNumberOfParticipants;

        $fee = $yearlyCost * $diskSpaceFactor * $participantsFactor;

        if($fee > 5)
            return 5;
        else if($fee < 0.01)
            return 0.01;
        else
            return $fee;
    }

    public function getEventInfo($eventID){
        $stmt = $this->db->prepare("select * from events where ID=?");
        $stmt->bind_param("i", $eventID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $this->getData($result);
        $this->close($stmt);
        
        if($data[0])
            return $data[1];
        else
            return [];
    }

    public function getNumberOfParticipants($eventID){
        $stmt = $this->db->prepare("select count(*) as num from eventparticipants where eventID=?");
        $stmt->bind_param("i", $eventID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $this->getData($result);

        if($data[0])
            return $data[1][0]['num'];
        else
            return 1;
    }

    public function getTotalNumberOfParticipants(){
        $stmt = $this->db->prepare("select count(*) as num from eventparticipants");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = $this->getData($result);
        
        if($data[0])
            return $data[1][0]['num'];
        else
            return 1;
    }

    private function close($obj){
        $obj->close();
    }
}
?>