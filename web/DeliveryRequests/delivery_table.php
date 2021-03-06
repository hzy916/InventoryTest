<?php 

	require_once('../inc/config.php');
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	
	$logged_user_id = $_SESSION['id'];

	require_once('../layouts/header.php'); 
	require_once('../layouts/side_bar.php'); 
  	require_once('../layouts/nav.php'); 

?>


  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="../dashboard.php">Dashboard</a>
        </li>
		<li class="breadcrumb-item active">Shipment Requests</li>
      </ol>
      <h1>Delivery request table</h1>
      <hr>
      <p><?php echo getUserName($_SESSION['id']); ?>  are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>

		<div>
			<div class="card card-body">
			<h3>Request Items List</h3>
			<table class="table table-bordered table-sm table-hover" id='requestProductTable' width='100%' cellspacing='0'>
				<thead>
					<tr>
						<th>item type</th>
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
				
					$sql = "SELECT pawtrails.itemname as name, pawtrails.id as id, pawtrails.color as color, pawtrails.size as size, pawtrails.itemtype as itemtype, Pawtrails_Request_junction.Qty as quantity FROM pawtrails, Pawtrails_Request_junction WHERE Pawtrails_Request_junction.request_id = '$request_id' AND Pawtrails_Request_junction.pawtrails_id = pawtrails.id" ;

					$result = $conn->query($sql);
			
					if($result->num_rows > 0) {
						while($row = $result->fetch_array()) {
							echo 
								"
								<tr>
									<td>".$row['itemtype']."</td>
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
	<div class="card mb-3 mt-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Your Delivery Request Table
		</div>

		<div class="card-body">
			<div class="table-responsive ">
				<table id="requestTable" class="table table-bordered table-sm table-hover" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Request ID</th>
							<th>Receiver Name</th>
							<th>Company Name</th>
							<th class="EmployeeColumn">Employee</th>
							<th>Submit date</th>
							<th>Ship date</th>
                            <th class="no-sort">Request Items</th>
							<th>Status</th>
							<th class="OperationColumn no-sort">operation</th>
						</tr>
					</thead>
						<tbody>
							<?php
							$sql = "SELECT Request.RequestID, Request.RequestEmployeeID, Request.RequestDate, Request.ShipDate, Receiver.first_name as first_name, Receiver.last_name as last_name, Receiver.company_name as company_name, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request  JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN Receiver ON Request.ReceiverID = Receiver.receiver_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE is_archived = 0";
							
							$result = $conn->query($sql);	
							$num_rows = mysqli_num_rows($result);
							if($result->num_rows > 0) {
								while($row = $result->fetch_array()) {
									$btText='Check';
									$btId='check'.$row['RequestID'];
									$btCls='btn btn-success checkBtn';
									$btCmd='checkRequest.php?id='.$row['RequestID'];
									$status_style = '';

									$status_name = $row['status_name'];
										switch ($status_name) {
											case "Completed":
									
												$status_style = 'color:#008000;';
												break;
											case "Delayed":
												$status_style = 'color:#ffa500;';
												break;
											case "Declined":
												$status_style = 'color:#DC143C;';
												break;
										}
				

									echo 
									"<tr>
										<td>".$row['RequestID']."</td>
										<td>".$row['first_name']."  ".$row['last_name']."</td>
										<td>".$row['company_name']."</td>
										<td class='EmployeeColumn'>".$row['user_name']."</td>
										<td>".$row['RequestDate']."</td>
										<td>".$row['ShipDate']."</td>
										<td>
											<button type='button' class='btn btn-info' onclick='JavaScript:GetRequestID(".$row['RequestID'].");'>See Request Items</button>
										</td>
										<td style='".$status_style."'>
										".$row['status_name']."
										</td>
										<td class='OperationColumn'>
										<a id='".$btId."' href='".$btCmd."'><button class='".$btCls."' type='button'>".$btText."</button></a>
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
 

	<script type="text/javascript">

		function GetRequestID(idR){
			$("#req2display").val(idR);
			$("#displayRequest").submit();
		}
			//table pagination
		$(document).ready(function () {
			$('#requestTable').DataTable({
				columnDefs: [
					{ targets: 'no-sort', orderable: false }
				]
			});
		});

	
	</script>


<?php  

if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3  ) {
	echo('<script>$("#createBtn").addClass("hidebutton");
	</script>' );
}
?>
<?php require_once('../layouts/footer.php'); ?>	
