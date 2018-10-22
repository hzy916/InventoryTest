<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
    


	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 


	
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        
      </ol>
      <h1>Welcome to Dashboard</h1>
      <hr>
      <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>
	  
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
            <h2>Add an product</h2>
            <form action="create_item.php" method="post">
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Item Name</th>
                        <td><input type="text" name="itemname" placeholder="Item Name" /></td>
                    </tr>     
                
                    <tr>
                        <th>Color</th>
                        <td><input type="text" name="color" placeholder="color" /></td>
                    </tr>

                    <tr>
                        <th>Size</th>
                        <td><input type="text" name="size" placeholder="Size" /></td>
                    </tr>

                    <tr>
                        <th>Amount</th>
                        <td><input type="text" name="amount" placeholder="Amount" /></td>
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


<?php require_once('layouts/footer.php'); ?>	