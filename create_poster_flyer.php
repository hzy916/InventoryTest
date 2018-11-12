
<?php

    require 'inc/config.php';
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		

	
    if($_POST) {
        $itemname = $_POST['itemname'];
        //item type
        $itemtype = $_POST['itemtype'];
    
        $amount = $_POST['amount'];
     
        if (isset($amount) && ctype_digit($amount))
        {
        // the get input contains a positive number and is safe
            $sql = "INSERT INTO pawtrails (itemtype, itemname, amount) VALUES ('$itemtype','$itemname', '$amount')";
            if($conn->query($sql) === TRUE) {
                // $msg = "New Product Successfully Created";
                echo "<script>
                alert('New Product Successfully Created.');
                window.location.href='./inventory.php';
                </script>";
            } else {
                // $msg = "Updating failed.";
                echo "Error " . $sql . ' ' . $conn->connect_error;
            }
            $conn->close();
        } else {
                echo "<script>
                alert('Number should be positive integers.');
                window.location.href='./create.php';
                </script>";
        }
    }
?>