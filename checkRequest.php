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
    
    $msg = "";

    if($_GET['id']) {
        $id = $_GET['id'];

        //get all the request details
        $sql = "SELECT * FROM Request WHERE RequestID = {$id}";
        $result = $conn->query($sql);
        
        $data = $result->fetch_assoc();
       
        //get employee name
        $sql_two = "SELECT user_name FROM tbl_users WHERE id = {$data['RequestEmployeeID']}";
        $result_two = $conn->query($sql_two);
        $data_two = $result_two->fetch_assoc();

        //get request item list
        $sql_three = "SELECT pawtrails_id FROM Pawtrails_Request_junction WHERE request_id = {$id}";
        $result_three = $conn->query($sql_three);
        $data_three = $result_three->fetch_assoc();

        // list($pId,$Qty)=explode(',', $data_three);

        $pawtrailsID_array[] = $data_three['pawtrails_id'];
									
        $pawtrailsids = join("','",$pawtrailsID_array);  
        // $pawtrailsQtys = join("','",$Qty);  

        $sql_four = "SELECT * FROM pawtrails WHERE id IN ('$pawtrailsids')";
        $result_four = $conn->query($sql_four);  
    }
?>


  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard.php">Dashboard</a>
        </li>
        
      </ol>
      <h1>Process Delivery Request</h1>
  
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
        <h2>Request Details</h2>
        <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Request ID</th>
							<th>Submit date</th>
							<th>Ship date</th>
                            <th>Employee</th>
							<th>Status</th>
							<th class="OperationColumn">operation</th>
						</tr>
					</thead>
		
						<tbody>
							<?php
                        
                                echo 
                                    "<tr>
                                        <td>".$data['RequestID']."</td>
                                        <td>".$data['RequestDate']."</td>
                                        <td>".$data['ShipDate']."</td>
                                        <td>".$data_two['user_name']."</td>
                                        <td>
                                        ".$data['RequestStatusID']."
                                        </td>
                                     
                                    </tr>";
                                
                            
							?>

							<form id="displayRequest" method="POST">
								<input type="hidden"  name="makeaction" value="displayRequest">
								<input id="req2display" type="hidden"  name="req2display" value="">
							</form>
					</tbody>
				</table>

                <h4>Request Item List</h4>
                    <p><?php echo $msg ?></p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="requestProductTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>item id</th>
                                        <th>item Name</th>
                                        <th>size</th>
                                        <th>color</th>
                                        <th>amount</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                <?php    
                                    if($result_four->num_rows > 0) {
                                        while($row_four = $result_four->fetch_assoc()) {
                                            echo 
                                            "<tr>
                                                <td>".$row_four['id']."</td>
                                                <td>".$row_four['itemname']."</td>

                                                <td>".$row_four['color']."</td>
                                                <td>".$row_four['size']."</td>
                                                <td>
                                                ".$row_four['RequestStatusID']."
                                                </td>
                                            </tr>";
                                        }
                                    }else {
                                        echo "Error " . $sql_three . ' ' . $conn->connect_error;
                                    }	

                                    $conn->close();
                                ?>
                        </tbody>
                    </table>
                    </div>
                    
                   <!-- Receiver's details-->
                   <h4>Receiver details</h4>
                    <p><?php echo $msg ?></p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="requestProductTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>item id</th>
                                        <th>item Name</th>
                                        <th>size</th>
                                        <th>color</th>
                                        <th>amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                        </tbody>
                    </table>
                    </div>

                    <button class='btn btn-success' type='button'>Approve</button>
                    <button class='btn btn-success' type='button'>Deny</button>

                    <div class="form-group">
                        <label for="comment">Comments:</label>
                        <textarea class="form-control" rows="5" id="comment"></textarea>
                    </div>

                    <td><a href="delivery_table.php"><button type="button" class="btn btn-primary">Back</button></a></td>

              </div>
            </div>
          </div>
    </div>

<?php require_once('layouts/footer.php'); ?>	