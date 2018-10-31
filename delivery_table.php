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
		<li class="breadcrumb-item active">Delivery Request Details</li>
      </ol>
      <h1>Welcome to Delivery Request Tables</h1>
      <hr>
      <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>

   	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Delivery Request Table
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Employee Name</th>
							<th>Submit date</th>
                            <th>Request Items</th>
							<th >Status</th>
						</tr>
					</thead>
		
						<tbody>
							<?php
							$sql = "SELECT * FROM Request";
							$result = $conn->query($sql);
	
							if($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									// $sql_two = "SELECT FROM tbl_users WHERE id = " .$row['RequestEmployeeID'].;
									// $result_two = $conn->query($sql_two);
									// while($row_two = $result_two->fetch_assoc()) {
									echo 
									    "<tr>
											<td>".$row['RequestID']."</td>
											<td>".$row_two['RequestEmployeeID']."</td>
                                            <td>".$row['RequestDate']."</td>
											<td><a class='btn btn-primary' data-toggle='collapse' href='#multiCollapseExample1' role='button' aria-expanded='false' aria-controls='multiCollapseExample1'>See request items</a></td>
											<td>
                                            ".$row['RequestStatusID']."
                                            </td>
										</tr>";
									// }
								}
							} else {
									echo "<tr><td colspan='5'><center>No Data Avaliable</center></td></tr>";
							}
							?>
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                            <div class="card card-body">
                                itemname: PawTrails
                            </div>
                        </div>
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

	</script>' );
}

?>
<?php require_once('layouts/footer.php'); ?>	