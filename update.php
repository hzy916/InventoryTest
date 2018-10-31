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
    
    $msg = "";

    if($_POST) {
    //remind message for users

    //validate number input
      $amount = $_POST['amount'];
      $id = $_POST['id'];
  
      if (is_numeric($amount)) {
              $sql = "UPDATE pawtrails SET amount = '$amount', date = CURRENT_TIMESTAMP WHERE id = {$id}";
              if($conn->query($sql) === TRUE) {
                  $msg = "Succcessfully Updated";
        
              } else {
                  $msg = "Erorr while updating record ";
             
              }
          }
          else {
          $msg = "Error: You did not enter numbers only. Please enter only numbers.";
          }
    }  

    if($_GET['id']) {
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM pawtrails WHERE id = {$id}";
        $result = $conn->query($sql);
        
        $data = $result->fetch_assoc();
        
        $conn->close();
    }
?>


  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard.php">Dashboard</a>
        </li>
        
      </ol>
      <h1>Welcome to Dashboard</h1>
  
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
        <h2>Edit product inventory</h2>
        <form method="post">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <th>ID</th>
                    <td><?php echo $data['id'] ?> </td>
                </tr>
                <tr>
                    <th>Item Name</th>
                    <td><?php echo $data['itemname'] ?></td>
                </tr>     
                <tr>
                    <th>color</th>
                    <td><?php echo $data['color'] ?></td>
                </tr>
                <tr>
                    <th>size</th>
                    <td><?php echo $data['size'] ?></td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td><input type="text" name="amount" id="amountid" placeholder="amount" value="<?php echo $data['amount'] ?>" /></td>
                </tr>
                
                <tr><?php echo $msg; ?></tr>

                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['id']?>" />
                    <td><button type="submit" class="btn btn-success">Save Changes</button></td>
                    <td><a href="dashboard.php"><button type="button" class="btn btn-info">Back</button></a></td>
                </tr>
            </table>
        </form>
          </div>

     

    </div>
    <!-- /.container-fluid-->


<?php require_once('layouts/footer.php'); ?>	