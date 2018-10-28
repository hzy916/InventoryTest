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

<style>
.hidebutton{
	display: none!important;
}

</style>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
		<li class="breadcrumb-item active">Inventory</li>
      </ol>
      <h1>Welcome to Dashboard</h1>
      <hr>
      <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>
	  
	  <p>You can create a product</p>
	  <a class="btn btn-primary" id="createBtn" href="create.php">Create</a>
		<br>
		<ul>
			<li><strong>John Doe</strong> has <strong>Administrator</strong> rights so all the left bar items are visible to him</li>
			<li><strong>Ahsan</strong> has <strong>Sales</strong> rights and he doesn't have access to Settings</li>
			<li><strong>Sarah</strong> has <strong>Marketing</strong> rights and she can't have access to Settings</li>
		</ul>	
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Data Table Example
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>item name</th>
							<th>color</th>
							<th>size</th>
							<th>amount</th>
							<th>Update date</th>
							<th class="OperationColumn">operation</th>
						</tr>
					</thead>
		
						<tbody>
							<?php
							$sql = "SELECT * FROM pawtrails";
							$result = $conn->query($sql);
	
							if($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo 
									"<tr>
											<td>".$row['id']."</td>
											<td>".$row['itemname']."</td>
											<td>".$row['color']."</td>
											<td>".$row['size']."</td>
											<td>".$row['amount']."</td>
											<td>".$row['date']."</td>
											<td class='OperationColumn'>
												<a href='update.php?id=".$row['id']."'><button class='btn btn-success' type='button'>Edit</button></a>
												<a href='remove.php?id=".$row['id']."'><button class='btn btn-danger' type='button'>Remove</button></a>
											</td>
										</tr>";
								}
							} else {
									echo "<tr><td colspan='5'><center>No Data Avaliable</center></td></tr>";
							}
							?>
					</tbody>
				</table>
              </div>
            </div>
		</div>
    </div>
    <!-- /.container-fluid-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php  

if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3  ) {
	echo('<script>$("#createBtn").addClass("hidebutton");
	$(".OperationColumn").addClass("hidebutton");
	</script>' );
}

?>
<?php require_once('layouts/footer.php'); ?>	