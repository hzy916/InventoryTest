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
?>

<?php
    if($_GET['id']) {
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM pawtrails WHERE id = {$id}";
        $result = $conn->query($sql);
        
        $data = $result->fetch_assoc();
        
        $conn->close();
    }
    $msg = "";
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
        <form action="edit.php" method="post">
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
                    <th>Amount</th>
                    <td><input type="text" name="amount" id="amountid" placeholder="amount" value="<?php echo $data['amount'] ?>" /><?php echo $msg; ?></td>
                </tr>
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



<?php



$number= $_POST['amount'];

if (is_numeric($number)) {
echo 'The number you entered is ' . $number. '. This is a valid number.';
}
else {
echo 'Error: You did not enter numbers only. Please enter only numbers.';
}

?>

<?php require_once('layouts/footer.php'); ?>	