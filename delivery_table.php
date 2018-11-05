<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	
	$logged_user_id = $_SESSION['id'];

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

			<div>
			<div class="card card-body">
			<h3>Request Items List</h3>
			<table class='table table-bordered' id='requestProductTable' width='100%' cellspacing='0'>
				<thead>
					<tr>
					
						<th>item id</th>
						<th>item Name</th>
						<th>Quantity</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_POST['req2display'])){
					$request_id = $_POST['req2display'];
			
				$sql = "SELECT pawtrails_id FROM Pawtrails_Request_junction WHERE request_id = '$request_id'" ;

				$result = $conn->query($sql);

				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {

						$id_array[] = $row['pawtrails_id'];
						// var_dump($id_array);
			
						$ids = join("','",$id_array);   
						$sql_two = "SELECT * FROM pawtrails WHERE id IN ('$ids')";
						$result_two = $conn->query($sql_two);

						if($result_two->num_rows > 0) {
							while($row_two = $result_two->fetch_assoc()) {
							echo 
							"
						
							<tr>
								<td>".$row_two['id']."</td>
								<td>".$row_two['itemname']."</td>
								<td>".$row_two['amount']."</td>
								
							</tr>";
							}
						}else {
							echo "Error " . $sql_two . ' ' . $conn->connect_error;
						}	
				
					}
				} else {
						echo "<tr><td colspan='5'><center>No Data Avaliable</center></td></tr>";
				}
			}
				?>
					</tbody>
				</table>
			</div>
		</div>

   	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Your Delivery Request Table
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Request ID</th>
							<th>Submit date</th>
							<th>Ship date</th>
                            <th>Request Items</th>
							<th>Status</th>
						</tr>
					</thead>
		
						<tbody>
							<?php
							if($_SESSION['user_role_id'] == 1) {
								$sql = "SELECT * FROM Request";
							} else{
								$sql = "SELECT * FROM Request WHERE RequestEmployeeID = '$logged_user_id'";
							}

								$result = $conn->query($sql);
		
								if($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {
												echo 
													"<tr>
														<td>".$row['RequestID']."</td>
														<td>".$row['RequestDate']."</td>
														<td>".$row['ShipDate']."</td>
														<td>
															<button type='button' class='btn btn-info' onclick='JavaScript:GetRequestID(".$row['RequestID'].");'>See Request Items</button>
														</td>
														<td>
														".$row['RequestStatusID']."
														</td>
													</tr>";
									
									}
								} else {
										echo "<tr><td colspan='5'><center>You have no related requests.</center></td></tr>";
								}
							?>

							<form id="displayRequest" method="POST">
								<input type="hidden"  name="makeaction" value="displayRequest">
								<input id="req2display" type="hidden"  name="req2display" value="">
							</form>
					</tbody>
				</table>


             
              </div>
            </div>
		</div>
    </div>
    <!-- /.container-fluid-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		function GetRequestID(idR){
			$("#req2display").val(idR);
			$("#displayRequest").submit();
		}
	</script>


<?php  

if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3  ) {
	echo('<script>$("#createBtn").addClass("hidebutton");

	</script>' );
}

?>
<?php require_once('layouts/footer.php'); ?>	
