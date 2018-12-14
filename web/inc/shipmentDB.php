<?php
    function getList($status, $conn){
        $sql = "SELECT Request.RequestID, Request.RequestEmployeeID, Request.RequestDate, Request.ShipDate, Receiver.first_name as first_name, Receiver.last_name as last_name, Receiver.company_name as company_name, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request  JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN Receiver ON Request.ReceiverID = Receiver.receiver_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE Request.RequestStatusID =". $status;

        return $conn->query($sql);	
        // $num_rows = mysqli_num_rows($result);
    }


    function getdesignList($status, $conn){
        $sql = "SELECT CustomRequest.customrequestID, CustomRequest.voucherCode, CustomRequest.quantity, CustomRequest.companyName, CustomRequest.itemtype, CustomRequest.c_RequestEmployeeID, CustomRequest.c_RequestDate, CustomRequest.UseDate,  Request_status.status_name as status_name, tbl_users.user_name as user_name FROM CustomRequest  JOIN Request_status ON CustomRequest.c_RequestStatusID = Request_status.status_id JOIN tbl_users ON  CustomRequest.c_RequestEmployeeID = tbl_users.id WHERE c_is_archived = 0 AND CustomRequest.c_RequestStatusID =". $status;
    
        return $conn->query($sql);	
        // $num_rows = mysqli_num_rows($result);
    }

    //get number of Shipment Request in different status
    function getNumberRequest($status, $conn){
        $sql = "SELECT * FROM Request Where Request.RequestStatusID =". $status;

        $result =   $conn->query($sql);
        $data = mysqli_num_rows($result);
    
        return $data;   
    }

     //get number of Design Request in different status
    function getNumberDesignRequest($status, $conn){
        $sql = "SELECT * FROM CustomRequest Where CustomRequest.c_RequestStatusID =". $status;

        $result =   $conn->query($sql);
        $data = mysqli_num_rows($result);
    
        return $data;   
    }
    

?>