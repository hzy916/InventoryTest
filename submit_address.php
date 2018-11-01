<?php
	// session_start();
	
	// if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	// {
	// 	header('location:index.php?lmsg=true');
	// 	exit;
    // }	
    
    // require_once 'inc/config.php';
    
    // echo "<script>
    // alert('post 0');
    // </script>";

    
 
    $user_id = $_SESSION['id']; 
  

        $receivercompany = $_POST['receivercompany'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phonenumber = $_POST['phonenumber'];
        $inputAddress1 = $_POST['inputAddress1'];
        $inputAddress2 = $_POST['inputAddress2'];
        $inputAddress3 = $_POST['inputAddress3'];
        $inputCity = $_POST['inputCity'];
        $inputCountry = $_POST['inputCountry'];
        $inputPostcode = $_POST['inputPostcode'];
        $deliverydate = $_POST['deliverydate'];


        if (!empty($receivercompany)) {
            $sql = "INSERT INTO Receiver (company_name, first_name, last_name, phone, address1, address2, address3, city, country, postalcode) VALUES ('$receivercompany', '$firstname',  '$lastname', '$phonenumber', '$inputAddress1', '$inputAddress2','$inputAddress3', '$inputCity', '$inputCountry', '$inputPostcode')";
       
        } else {
            $sql = "INSERT INTO Receiver (first_name, last_name, phone, address1, address2, address3, city, country, postalcode) VALUES ('$firstname',  '$lastname', '$phonenumber', '$inputAddress1', '$inputAddress2','$inputAddress3', '$inputCity', '$inputCountry', '$inputPostcode')";
       
        }

       
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo "Receiver id is " .  $last_id . "<br>";
            //update Request details
            $sql_two= "INSERT INTO Request (ReceiverID, ShipDate, RequestStatusID, RequestEmployeeID) VALUES ('$last_id', '$deliverydate',  '1', '$user_id')";
         
            if($conn->query($sql_two) === TRUE) {
                $request_id = $conn->insert_id;
                // $sql_three = "Update Pawtrails_Request_junction SET (request_id) = ( '$request_id') WHERE pawtrails_id = ";
                // if($conn->query($sql_three) === TRUE) {
                //     echo "<script>
                //     alert('Delivery Request Submitted successfully');
                //     window.location.href='./delivery_table.php';
                //     </script>";
                // } else{
                    
                //  echo "Error " . $sql_three . ' ' . $conn->connect_error;
                // }



                //Grab the value of request items
                
                // $mylist = explode('@', $_POST['myPlist']);
                // array_shift($mylist);

                // print("<br><br><br><br>");

                // foreach ($mylist as $k){
                //     list($sel_product, $deliverynumber) = explode('-', $k);
                //     //prepare the insert multiple query 
                //     $sql_four = "INSERT INTO Pawtrails_Request_junction (request_id,pawtrails_id, Qty) VALUES ('$request_id','$sel_product',  '$deliverynumber')";
                //     $conn->query($sql_four);
                    
                
                // }
                    $mylist = explode('@', $_POST['myPlist']);
                    array_shift($mylist);
                    if(!empty($mylist)){
                        $last=count($mylist);
                        $i=1;
                        $sql_four = "INSERT INTO Pawtrails_Request_junction (request_id,pawtrails_id, Qty) VALUES ";
                    
                        foreach ($mylist as $k){
                            list($sel_product, $deliverynumber) = explode('-', $k);
                            //prepare the insert multiple query 
                            $sql_four .= "('$request_id','$sel_product',  '$deliverynumber')";

                        if($i==$last){
                            $sql_four .= ";";
                        }else {
                            $sql_four .= ",";
                        }
                        $i++;
                        }
                        $conn->query($sql_four);
                    }


            } else {
                // $msg = "Updating failed.";
                echo "Error " . $sql_two . ' ' . $conn->connect_error;
            }
        

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
?>
