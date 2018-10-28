<?php
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
    }	
    
    require 'inc/config.php';

    

    if($_POST) {
        $deliverydate = $_POST['deliverydate'];
        // $receivercompany = $_POST['receivercompany'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phonenumber = $_POST['phonenumber'];
        $inputAddress = $_POST['inputAddress'];
     
        $sql = "INSERT INTO Receiver (pawtrails_id, Qty) VALUES ('$sel_product',  '$deliverynumber')";
        if($conn->query($sql) === TRUE) {

            echo "<script>
            alert('Item added successfully');
            window.location.href='./delivery_request.php';
            </script>";

        } else {
            // $msg = "Updating failed.";
            echo "Error " . $sql . ' ' . $conn->connect_error;
        }
        $conn->close();
    }
?>