<?php 

	
	require_once('inc/config.php');
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	
	$logged_user_id = $_SESSION['id'];

	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
?>

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
			<table class="table table-bordered table-sm table-hover" id='requestProductTable' width='100%' cellspacing='0'>
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
				<table class="table table-bordered" id="archivedTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Receiver Name</th>
							<th>Request ID</th>
							<th class="EmployeeColumn">Employee</th>
							<th>Submit date</th>
							<th>Ship date</th>
							<th class="no-sort">Request Items</th>
							<th>Status</th>
						</tr>
					</thead>
						<tbody>
							<?php
					
                            //get all archived request and list in a table
							// $sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Receiver.first_name as first_name, Receiver.last_name as last_name, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE is_archived = 1";
							if($_SESSION['user_role_id'] == 1) {
						
								$sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Receiver.first_name as first_name, Receiver.last_name as last_name, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN Receiver ON Request.ReceiverID = Receiver.receiver_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE is_archived = 1";
								
								} else{
							
								$sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Receiver.first_name as first_name, Receiver.last_name as last_name, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN Receiver ON Request.ReceiverID = Receiver.receiver_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE RequestEmployeeID = '$logged_user_id' AND is_archived = 1";
								}

							$result = $conn->query($sql);	
							$num_rows = mysqli_num_rows($result);
							if($result->num_rows > 0) {
								while($row = $result->fetch_array()) {
								
									echo 
									"<tr>
										<td>".$row['first_name']."  ".$row['last_name']."</td>
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
									
									</tr>";
								}
							}else {
								// echo "Error " . $sql . ' ' . $conn->connect_error;
								echo "No data available";
							}
							?>

						
					</tbody>
				</table>
              </div>
            </div>
		</div>
    </div>

		<form id="displayRequest" method="POST">
			<input type="hidden"  name="makeaction" value="displayRequest">
			<input id="req2display" type="hidden"  name="req2display" value="">
		</form>

	<script>
		//table pagination
			$(document).ready(function () {
			$('#archivedTable').DataTable({
				columnDefs: [
					{ targets: 'no-sort', orderable: false }
				]
			});
		});


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
