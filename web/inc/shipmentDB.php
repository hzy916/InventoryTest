<?php
    function getList($status, $conn){
        $sql = "SELECT Request.RequestID, Request.RequestEmployeeID, Request.RequestDate, Request.ShipDate, Receiver.first_name as first_name, Receiver.last_name as last_name, Receiver.company_name as company_name, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request  JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN Receiver ON Request.ReceiverID = Receiver.receiver_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE Request.RequestStatusID =". $status;

        return $conn->query($sql);	
        // $num_rows = mysqli_num_rows($result);
    }

    

?>