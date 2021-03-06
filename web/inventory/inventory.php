<?php 

	require_once('../inc/config.php');
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		

	require_once('../layouts/header.php'); 
	require_once('../layouts/side_bar.php'); 
  	require_once('../layouts/nav.php'); 

?>


  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard.php">Home</a>
        </li>
		<li class="breadcrumb-item active">Inventory</li>
      </ol>
      <h1>Welcome to Dashboard</h1>
      <hr>
      <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>
	
	<?php
		if($_SESSION['user_role_id'] == 1 ) {
			echo "<p>You can create a product</p>
			<a class='btn btn-primary' id='createBtn' href='create.php'>Create</a>
				<br>";
		}
	?>
	<!-- DataTables Example -->
	<div class="card mb-3 mt-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Inventory Table
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<h5>PawTrails All In One GPS Tracker</h5>
				<table class="table datatable table-striped table-bordered table-sm table-hover" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="th-sm">ID
							
							</th>
							<th class="th-sm">
								item name
							
							</th>
							<th class="th-sm">
								color
							
							</th>
							
							<th class="th-sm">
								size
							
							</th>
							<th class="th-sm">
								Quantity
						
							</th>
							<th class="th-sm">
								Update date
							
							</th>
							<th class="OperationColumn th-sm">operation</th>
						</tr>
					</thead>
		
						<tbody>
							<?php
							$sql = "SELECT * FROM pawtrails WHERE color is NOT NULL";
							$result = $conn->query($sql);
	
							if($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									// set styles the way you want
									if($row['color'] == 'red') {
										$tdStyle='background-color:#DC143C;';
									} else {
										$tdStyle='background-color:#A9A9A9;';
									}
									echo 
									"<tr>
											<td>".$row['id']."</td>
											<td>".$row['itemname']."</td>
											<td style= $tdStyle >".$row['color']."</td>
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

			  <div class="table-responsive">
			  	<h5>PawTrails Posters and Flyers</h5>
				<table  class="table datatable table-striped table-bordered table-sm table-hover" id="flyerTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>item name</th>
							<th>Quantity</th>
							<th>Update date</th>
							<th class="OperationColumn no-sort">operation</th>
						</tr>
					</thead>
		
						<tbody>
							<?php
							$sql = "SELECT * FROM pawtrails WHERE color is NULL";
							$result = $conn->query($sql);
	
							if($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo 
									"<tr>
										<td>".$row['id']."</td>
										<td>".$row['itemname']."</td>
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

<script>
$('#flyerTable').dataTable({
				columnDefs: [
					{ targets: 'no-sort', orderable: false }
				]
			});
</script>
	

<?php  
	if($_SESSION['user_role_id'] != 1 ) {
		echo('<script>$("#createBtn").addClass("hidebutton");
		$(".OperationColumn").addClass("hidebutton");
		</script>' );
	}
?>

<?php require_once('../layouts/footer.php'); ?>	