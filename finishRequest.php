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
        $id = $_GET['id'];
        
        $sql_finish = "UPDATE Request SET RequestStatusID = 5 WHERE Request.RequestID = '$id'";
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

