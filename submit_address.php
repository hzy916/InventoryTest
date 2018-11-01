<?php
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
    }	
    
    require 'inc/config.php';
    
    echo "<script>
    alert('post 0');
    </script>";

    $user_id = $_SESSION['id']; 

    if($_POST) {
        
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
                echo "<script>
                alert('Delivery Request Submitted successfully');
                window.location.href='./delivery_table.php';
                </script>";
            } else {
                // $msg = "Updating failed.";
                echo "Error " . $sql_two . ' ' . $conn->connect_error;
            }
            $conn->close();

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


      
          
            // $receivercompany = $_POST['receivercompany'];
            // if(isset($receivercompany)) {
            //     $sql .= "INSERT INTO Receiver ( company_name, first_name, last_name, phone, address, city, country, postalcode) VALUES ('$receivercompany', '$firstname',  '$lastname', '$phonenumber', '$inputAddress', '$inputCity', '$inputCountry', '$inputPostcode')";
            // } else {
              
 
            // }
    }
?>

