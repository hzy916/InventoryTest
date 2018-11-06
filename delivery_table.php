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
			
				$sql = "SELECT pawtrails.itemname as name, pawtrails.id as id, Pawtrails_Request_junction.Qty as quantity FROM pawtrails, Pawtrails_Request_junction WHERE Pawtrails_Request_junction.request_id = '$request_id' AND Pawtrails_Request_junction.pawtrails_id = pawtrails.id" ;

				$result = $conn->query($sql);
			

				if($result->num_rows > 0) {
					while($row = $result->fetch_array()) {
						echo 
							"
							<tr>
								<td>".$row['id']."</td>
								<td>".$row['name']."</td>
								<td>".$row['quantity']."</td>
								
							</tr>";
					}
				}else {
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
							<th class="EmployeeColumn">Employee</th>
							<th>Submit date</th>
							<th>Ship date</th>
                            <th>Request Items</th>
							<th>Status</th>
							<th class="OperationColumn">operation</th>
						</tr>
					</thead>
		
						<tbody>
							<?php
							if($_SESSION['user_role_id'] == 1) {
								$sql = "SELECT * FROM Request WHERE is_archived = 0";
							} else{
								$sql = "SELECT * FROM Request WHERE RequestEmployeeID = '$logged_user_id' AND is_archived = 0";
							}

								$result = $conn->query($sql);
		
								if($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {

										$employeeID_array[] = $row['RequestEmployeeID'];
										// var_dump($id_array);
							
										$employeeids = join("','",$employeeID_array);   
										$sql_three = "SELECT user_name FROM tbl_users WHERE id IN ('$employeeids')";
										$result_three = $conn->query($sql_three);
											if($result_three->num_rows > 0) {
												while($row_three = $result_three->fetch_assoc()) {
													
													//get status from status table using status id 
													$statusID_array[] = $row['RequestStatusID'];
													$statusids = join("','",$statusID_array);   
													$sql_four = "SELECT status_name FROM Request_status WHERE status_id IN ('$statusids')";

													$result_four = $conn->query($sql_four);
													if($result_four->num_rows > 0) {
														while($row_four = $result_four->fetch_assoc()) {
															echo 
															"<tr>
																<td>".$row['RequestID']."</td>
																<td class='EmployeeColumn'>".$row_three['user_name']."</td>

																<td>".$row['RequestDate']."</td>
																<td>".$row['ShipDate']."</td>
																<td>
																	<button type='button' class='btn btn-info' onclick='JavaScript:GetRequestID(".$row['RequestID'].");'>See Request Items</button>
																</td>
																<td>
																".$row_four['status_name']."
																</td>
																<td class='OperationColumn'>
																	<a href='checkRequest.php?id=".$row['RequestID']."'><button class='btn btn-success' type='button'>Approve</button></a>
																</td>
															</tr>";
														}
													}else {
														echo "Error " . $sql_four . ' ' . $conn->connect_error;
													}	
												}
											}else {
												echo "Error " . $sql_three . ' ' . $conn->connect_error;
											}	
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
	$(".OperationColumn").addClass("hidebutton");
	$(".EmployeeColumn").addClass("hidebutton");
	
	</script>' );


		
	
	
	
}

?>
<?php require_once('layouts/footer.php'); ?>	
