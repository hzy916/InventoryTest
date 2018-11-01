<?php
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
        exit;
        $requestUserID = $_SESSION['id'];
    }	
    
    require 'inc/config.php';

    if($_POST) {
        $sel_product = $_POST['sel_product'];
        // $sel_color = $_POST['sel_color'];
        // $sel_size = $_POST['sel_size'];
        $deliverynumber = $_POST['deliverynumber'];
        
      

        $sql = "INSERT INTO Pawtrails_Request_junction (pawtrails_id, Qty) VALUES ('$sel_product',  '$deliverynumber')";

        if($conn->query($sql) === TRUE) {
            $last_junction_id = $_POST['sel_product']."-".$conn->insert_id;
            
            echo "<script>
            alert('Item added successfully');</script>";

            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;

        } else {
            // $msg = "Updating failed.";
            echo "Error " . $sql . ' ' . $conn->connect_error;
        }
        $conn->close();
    }
?>

