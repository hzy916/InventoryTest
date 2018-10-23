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
     //remind user message
     $msg = "";

?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
        
      </ol>
      <h1>Welcome to Dashboard</h1>
      <hr>
      <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>
	  
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
            <h2>Add an product</h2>
            <form method="post">
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Item Name</th>
                        <td><input type="text" name="itemname" placeholder="Item Name" required/></td>
                    </tr>     
                
                    <tr>
                        <th>Color</th>
                        <td><input type="text" name="color" placeholder="color" /></td>
                    </tr>

                    <tr>
                        <th>Size</th>
                        <td><input type="text" name="size" placeholder="Size"/></td>
                    </tr>

                    <tr>
                        <th>Amount</th>
                        <td><input type="text" name="amount" placeholder="Amount" required /></td>
                    </tr>
                    <tr>
                        <td><button type="submit" class="btn btn-success">Save</button></td>
                        <td><a href="dashboard.php"><button type="button" class="btn btn-danger">Back</button></a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- /.container-fluid-->

<?php
    if($_POST) {
        $itemname = $_POST['itemname'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $amount = $_POST['amount'];
     
        $sql = "INSERT INTO pawtrails (itemname, color, size, amount) VALUES ('$itemname', '$color', '$size', '$amount')";
        if($conn->query($sql) === TRUE) {
            // $msg = "New Product Successfully Created";
            echo "New Product Successfully Created";
        } else {
            // $msg = "Updating failed.";
            echo "Error " . $sql . ' ' . $conn->connect_error;
        }
        $conn->close();
    }
?>

<?php require_once('layouts/footer.php'); ?>	