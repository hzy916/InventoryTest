<?php
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
    }	
    
    require 'inc/config.php';
    require_once('layouts/header.php'); 
    require_once('layouts/left_sidebar.php'); 
    

    if($_POST) {
        $sel_product = $_POST['sel_product'];
        // $sel_color = $_POST['sel_color'];
        // $sel_size = $_POST['sel_size'];
        $deliverynumber = $_POST['deliverynumber'];
     
        $sql = "INSERT INTO Pawtrails_Request_junction (pawtrails_id, Qty) VALUES ('$sel_product',  '$deliverynumber')";
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