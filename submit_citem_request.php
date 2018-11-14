<?php
    $user_id = $_SESSION['id']; 

        $customType = mysqli_real_escape_string($conn,$_POST['customType']);
        $vouchercode =  mysqli_real_escape_string($conn,$_POST['vouchercode']);
        $companyname =  mysqli_real_escape_string($conn,$_POST['companyname']);
        $usingdate =  mysqli_real_escape_string($conn,$_POST['usingdate']);
        $quantity =  mysqli_real_escape_string($conn,$_POST['quantity']);
       

       
         //Insert Custom Request details
            $sql= "INSERT INTO CustomRequest (UseDate, c_RequestStatusID, c_RequestEmployeeID, voucherCode, companyName, quantity, itemType) VALUES ('$usingdate', '$deliverydate', '$user_id', )";
         
            if($conn->query($sql) === TRUE) {
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
        

    
?>


