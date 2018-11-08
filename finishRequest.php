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
    
    if($_GET['id']) {
        $request_id = $_GET['id'];
        
        //get the product id and number requested, and update inventory when request is completed. 
        $sql_update = "UPDATE pawtrails JOIN Pawtrails_Request_junction ON pawtrails.id = Pawtrails_Request_junction.pawtrails_id && Pawtrails_Request_junction.request_id = '$request_id' SET pawtrails.amount = pawtrails.amount - Pawtrails_Request_junction.Qty"; 
       
        //check if update stock successfully
        if ($conn->query($sql_update) === TRUE) {
            echo "<script>
            alert('The related product inventory is updated!');
            </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        } 

        $sql_finish = "UPDATE Request SET RequestStatusID = 5 WHERE Request.RequestID = '$request_id'";
        if ($conn->query($sql_finish) === TRUE) {
            echo "<script>
            alert('You finished this request, it goes to completed status.');
            window.location.href='./delivery_table.php';
            </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }   
     
        $conn->close();
    }
      
?>

