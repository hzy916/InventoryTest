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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
						<th>Size</th>
						<th>Color</th>
						<th>Quantity</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_POST['req2display'])){
					$request_id = $_POST['req2display'];
			
				$sql = "SELECT pawtrails.itemname as name, pawtrails.id as id, pawtrails.color as color, pawtrails.size as size,  Pawtrails_Request_junction.Qty as quantity FROM pawtrails, Pawtrails_Request_junction WHERE Pawtrails_Request_junction.request_id = '$request_id' AND Pawtrails_Request_junction.pawtrails_id = pawtrails.id" ;

				$result = $conn->query($sql);
			

				if($result->num_rows > 0) {
					while($row = $result->fetch_array()) {
						echo 
							"
							<tr>
								<td>".$row['id']."</td>
								<td>".$row['name']."</td>
								<td>".$row['size']."</td>
								<td>".$row['color']."</td>
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
							// 	$sql = "SELECT * FROM Request WHERE is_archived = 0";
							$sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE is_archived = 0";
							
							} else{
							// 	$sql = "SELECT * FROM Request WHERE RequestEmployeeID = '$logged_user_id' AND is_archived = 0";
							$sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE RequestEmployeeID = '$logged_user_id' AND is_archived = 0";
							}

							// $sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id";
							
							$result = $conn->query($sql);	
							$num_rows = mysqli_num_rows($result);
							if($result->num_rows > 0) {
								while($row = $result->fetch_array()) {
									$btText='Check';
									$btId='check'.$row['RequestID'];
									$btCls='btn btn-success checkBtn';
									$btCmd='checkRequest.php?id='.$row['RequestID'];
								
										if($row['status_name'] == 'Processing') {
											$btText='Finish';
											$btId='finish'.$row['RequestID'];
											$btCls='btn btn-danger finishBtn';
											$btCmd='finishRequest.php?id='.$row['RequestID'];
										} else if ($row['status_name'] == 'Completed'){
											$btText='Archive';
											$btId='archive'.$row['RequestID'];
											$btCls='btn btn-primary archiveBtn';
											$btCmd='archiveRequest.php?id='.$row['RequestID'];
										}


									echo 
									"<tr>
										<td>".$row['RequestID']."</td>
										<td>".$row['user_name']."</td>
										<td>".$row['RequestDate']."</td>
										<td>".$row['ShipDate']."</td>
										<td>
											<button type='button' class='btn btn-info' onclick='JavaScript:GetRequestID(".$row['RequestID'].");'>See Request Items</button>
										</td>
										<td>
										".$row['status_name']."
										</td>
										<td class='OperationColumn'>
											
										<a id='".$btId."' href='".$btCmd."'><button class='".$btCls."' type='button'>".$btText."</button></a>
										</td>
									</tr>";
								}
							}else {
								echo "Error " . $sql . ' ' . $conn->connect_error;
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
