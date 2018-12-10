<?php
    $user_id = $_SESSION['id']; 
 
        $receivercompany = mysqli_real_escape_string($conn,$_POST['receivercompany']);
        $fullname =  mysqli_real_escape_string($conn,$_POST['firstname']);
        $phonenumber =  mysqli_real_escape_string($conn,$_POST['phonenumber']);
        $inputAddress1 =  mysqli_real_escape_string($conn,$_POST['inputAddress1']);
        $inputAddress2 =  mysqli_real_escape_string($conn,$_POST['inputAddress2']);
        $inputAddress3 = mysqli_real_escape_string($conn,$_POST['inputAddress3']);
        $inputCity =  mysqli_real_escape_string($conn,$_POST['inputCity']);
        $inputCountry =  mysqli_real_escape_string($conn,$_POST['inputCountry']);
        $inputPostcode =  mysqli_real_escape_string($conn,$_POST['inputPostcode']);
        $deliverydate =  mysqli_real_escape_string($conn,$_POST['deliverydate']);
        $receiverEmail =  mysqli_real_escape_string($conn,$_POST['receiverEmail']);

        //check if company field is empty
        if (!empty($company)) {
            $sql = "INSERT INTO Receiver (company_name, first_name, phone, address1, address2, address3, city, country, postalcode, receiver_email ) VALUES ('$receivercompany', '$fullname',  '$phonenumber', '$inputAddress1', '$inputAddress2','$inputAddress3', '$inputCity', '$inputCountry', '$inputPostcode', '$receiverEmail')";
       
        } else {
            $sql = "INSERT INTO Receiver (first_name, phone, address1, address2, address3, city, country, postalcode, receiver_email) VALUES ('$fullname', '$phonenumber', '$inputAddress1', '$inputAddress2','$inputAddress3', '$inputCity', '$inputCountry', '$inputPostcode','$receiverEmail')";
       
        }
        //insert into the request table
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            // echo "Receiver id is " .  $last_id . "<br>";
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
                        //clear the data in the session
                        unset($_SESSION['delivery']);
                        unset($_SESSION['requestDetails']);

                        echo "<script>
                        alert('New Request Successfully Submitted.');
                        include ('shipmentSuccess.php');
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


