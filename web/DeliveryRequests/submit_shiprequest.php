<?php
    $user_id = $_SESSION['id']; 

        // $receivercompany = mysqli_real_escape_string($conn,$_POST['receivercompany']);
        // $firstname =  mysqli_real_escape_string($conn,$_POST['firstname']);
        // $lastname =  mysqli_real_escape_string($conn,$_POST['lastname']);
        // $phonenumber =  mysqli_real_escape_string($conn,$_POST['phonenumber']);
        // $inputAddress1 =  mysqli_real_escape_string($conn,$_POST['inputAddress1']);
        // $inputAddress2 =  mysqli_real_escape_string($conn,$_POST['inputAddress2']);
        // $inputAddress3 = mysqli_real_escape_string($conn,$_POST['inputAddress3']);
        // $inputCity =  mysqli_real_escape_string($conn,$_POST['inputCity']);
        // $inputCountry =  mysqli_real_escape_string($conn,$_POST['inputCountry']);
        // $inputPostcode =  mysqli_real_escape_string($conn,$_POST['inputPostcode']);
        // $deliverydate =  mysqli_real_escape_string($conn,$_POST['deliverydate']);
        // $receiverEmail =  mysqli_real_escape_string($conn,$_POST['receiverEmail']);


     
        if(!empty($_SESSION['requestDetails'])){
            echo "  <h3>Receiver Details</h3>";
            foreach($_SESSION['requestDetails'] as $i=> $k) {
                echo "
                    <p>".$k['fullname']."</p>
                    <p>".$k['company']."</p>
                    <p>".$k['phonenumber']."</p>
                    <p>".$k['receiverEmail']."</p>";
                    $i++;
                }  
        }
 
        if(!empty($_SESSION['requestDetails'])){
            foreach($_SESSION['requestDetails'] as $i=> $k) {
                echo "
                    <p>".$k['inputAddress1']."</p>
                    <p>".$k['inputAddress2']."</p>
                    <p>".$k['inputAddress3']."</p>
                    <p>".$k['receiverEmail']."</p>
                    <p>".$k['inputCity']."</p>
                    <p>".$k['inputCountry']."</p>
                    <p>".$k['inputPostcode']."</p>";
                    
                    $i++;
                }  
        }
  


        if (!empty($receivercompany)) {
            $sql = "INSERT INTO Receiver (company_name, first_name, last_name, phone, address1, address2, address3, city, country, postalcode, receiver_email ) VALUES ('$receivercompany', '$firstname',  '$lastname', '$phonenumber', '$inputAddress1', '$inputAddress2','$inputAddress3', '$inputCity', '$inputCountry', '$inputPostcode', '$receiverEmail')";
       
        } else {
            $sql = "INSERT INTO Receiver (first_name, last_name, phone, address1, address2, address3, city, country, postalcode, receiver_email) VALUES ('$firstname',  '$lastname', '$phonenumber', '$inputAddress1', '$inputAddress2','$inputAddress3', '$inputCity', '$inputCountry', '$inputPostcode','$receiverEmail')";
       
        }
       
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo "Receiver id is " .  $last_id . "<br>";
            //update Request details
            $sql_two= "INSERT INTO Request (ReceiverID, ShipDate, RequestStatusID, RequestEmployeeID) VALUES ('$last_id', '$deliverydate',  '1', '$user_id')";
         
            if($conn->query($sql_two) === TRUE) {
                $request_id = $conn->insert_id;

              
                //Grab the value of request items
                if(!empty($_SESSION['delivery'])){
                    $last=count($_SESSION['delivery']);
                    $i=1;

                    $sql_four = "INSERT INTO Pawtrails_Request_junction (request_id,pawtrails_id, Qty) VALUES ";
                
                    foreach ($_SESSION['delivery'] as $k){
                        // list($sel_product, $deliverynumber) = explode('-', $k);
                        //prepare the insert multiple query 
                        $sql_four .= "('$request_id','".$k['product_id']."', '".$k['deliverynumber']."')";

                    if($i==$last){
                        $sql_four .= ";";
                    }else {
                        $sql_four .= ",";
                    }
                    $i++;
                    }
                    if($conn->query($sql_four) === TRUE) {
                        unset($_SESSION['delivery']);
                        echo "<script>
                        alert('New Request Successfully Submitted.');
                        window.location.href='./delivery_table.php';
                        </script>";

                    }else{
                        echo "Error " . $sql_four . ' ' . $conn->connect_error;
                        echo "<script type=\"text/javascript\">".
                        "alert('Your Delivery Request submit failed.');".
                        "</script>";
                    }
                }

            } else {
                // $msg = "Updating failed.";
                echo "Error " . $sql_two . ' ' . $conn->connect_error;
                echo "<script type=\"text/javascript\">".
                "alert('Your Delivery Request submit failed.');".
                "</script>";
            }
        

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
?>


