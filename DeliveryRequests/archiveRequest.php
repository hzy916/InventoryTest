<?php 

    require 'inc/config.php';
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php');   
    
    if($_GET['id']) {
        $id = $_GET['id'];
        
        $sql_archive = "UPDATE Request SET is_archived = 1 WHERE Request.RequestID = '$id'";
        if ($conn->query($sql_archive) === TRUE) {
            echo "<script>
            alert('You archived this request, it goes to archived status.');
            window.location.href='./delivery_table.php';
            </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
            
            $conn->close();
    }
      
?>

