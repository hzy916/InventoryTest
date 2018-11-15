<?php 

	require_once('inc/config.php');
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	

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
		<li class="breadcrumb-item active">Custom Request List</li>
      </ol>
      <h1>Custom request table</h1>
      <hr>
      <p><?php echo getUserName($_SESSION['id']); ?>  are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>


   	<!-- DataTables Example -->
	<div class="card mb-3 mt-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Your Delivery Request Table
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table id="customTable" class="table table-bordered table-sm table-hover" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Item name</th>
							<th class="EmployeeColumn">Employee</th>
							<th>Submit date</th>
							<th>Use date</th>
                            <th>Quantity</th>
                            <th>Voucher Code</th>
							<th>Status</th>
							<th class="OperationColumn no-sort">operation</th>
						</tr>
					</thead>
						<tbody>
							<?php
							$sql = "SELECT CustomRequest.customrequestID, CustomRequest.voucherCode, CustomRequest.quantity, CustomRequest.companyName, CustomRequest.itemtype, CustomRequest.c_RequestEmployeeID, CustomRequest.c_RequestDate, CustomRequest.UseDate,  Request_status.status_name as status_name, tbl_users.user_name as user_name FROM CustomRequest  JOIN Request_status ON CustomRequest.c_RequestStatusID = Request_status.status_id JOIN tbl_users ON  CustomRequest.c_RequestEmployeeID = tbl_users.id WHERE c_is_archived = 0";
                            
                            $result = $conn->query($sql);	
							$num_rows = mysqli_num_rows($result);
							if($result->num_rows > 0) {
								while($row = $result->fetch_array()) {
									$btText='Check';
									$btId='check'.$row['customrequestID'];
									$btCls='btn btn-success checkBtn';
									$btCmd='check_custom_request.php?id='.$row['customrequestID'];
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
										<td>".$row['customrequestID']."</td>
										<td>".$row['itemtype']."  ".$row['companyName']."</td>
									
                                        <td class='EmployeeColumn'>".$row['user_name']."</td>
                                        <td>".$row['c_RequestDate']."</td>
									
										<td>".$row['UseDate']."</td>
                                        <td>".$row['quantity']."</td>
                                        <td>".$row['voucherCode']."</td>
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


	<script type="text/javascript">

	    //table pagination
		$(document).ready(function () {
			$('#customTable').DataTable({
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
<?php require_once('layouts/footer.php'); ?>	
