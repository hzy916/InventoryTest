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
        // $sql = "SELECT * FROM Request WHERE RequestID = {$id}";
        $sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Request_status.status_name as status_name, tbl_users.user_name as user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id";

        $result = $conn->query($sql);
        
        $data = $result->fetch_assoc();
       
        // //get employee name
        // $sql_two = "SELECT user_name FROM tbl_users WHERE id = {$data['RequestEmployeeID']}";
        // $result_two = $conn->query($sql_two);
        // $data_two = $result_two->fetch_assoc();

        // //get status name
        // $sql_5 = "SELECT status_name FROM Request_status WHERE status_id = {$data['RequestStatusID']}";
        // $result_5 = $conn->query($sql_5);
        // $data_5 = $result_5->fetch_assoc();

        //get receiver details
        $sql_two = "SELECT * FROM Receiver JOIN Request ON Receiver.receiver_id = Request.ReceiverID  WHERE Request.RequestID = '{$id}' ";
        $result_two = $conn->query($sql_two);  

        //get request item list
        $sql_three = "SELECT pawtrails.itemname as name, pawtrails.id as id, pawtrails.color as color, pawtrails.size as size,  Pawtrails_Request_junction.Qty as quantity FROM pawtrails, Pawtrails_Request_junction WHERE Pawtrails_Request_junction.request_id = '{$id}' AND Pawtrails_Request_junction.pawtrails_id = pawtrails.id" ;
        $result_three = $conn->query($sql_three);  
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
						</tr>
					</thead>
		
						<tbody>
							<?php
                                echo 
                                    "<tr>
                                        <td>".$data['RequestID']."</td>
                                        <td>".$data['RequestDate']."</td>
                                        <td>".$data['ShipDate']."</td>
                                        <td>".$data['user_name']."</td>
                                        <td>
                                        ".$data['status_name']."
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
                                        <th>Quantity</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                <?php    
                                    if($result_three->num_rows > 0) {
                                        while($row_three = $result_three->fetch_assoc()) {
                                            echo 
                                            "<tr>
                                                <td>".$row_three['id']."</td>
                                                <td>".$row_three['name']."</td>

                                                <td>".$row_three['color']."</td>
                                                <td>".$row_three['size']."</td>
                                                <td>
                                                ".$row_three['quantity']."
                                                </td>
                                            </tr>";
                                        }
                                    }else {
                                        echo "Error " . $sql_three . ' ' . $conn->connect_error;
                                    }	

                                
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
                                        <th>Receiver id</th>
                                        <th>Company Name</th>
                                        <th>First Name</th>
                                        <th>First Name</th>
                                        <th>Phone</th>
                                        <th>First Name</th>
                                        <th>Phone</th>
                                        <th>First Name</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php    
                                    if($result_two->num_rows > 0) {
                                        while($row_two = $result_two->fetch_assoc()) {
                                            echo 
                                            "<tr>
                                                <td>".$row_two['receiver_id']."</td>
                                                <td>".$row_two['company_name']."</td>
                                                <td>".$row_two['first_name']."</td>
                                                <td>".$row_two['last_name']."</td>
                                                <td>".$row_two['phone']."</td>
                                                <td>".$row_two['address1']."</td>
                                                <td>".$row_two['address2']."</td>
                                                <td>".$row_two['address3']."</td>
                                                <td>
                                                ".$row_two['city']."
                                                </td>
                                            </tr>";
                                        }
                                    }else {
                                        echo "Error " . $sql_three . ' ' . $conn->connect_error;
                                    }	

                            
                                ?>
                            </tbody>
                    </table>
                    </div>

                  

                    <div class="form-group">
                        <label for="comment">Comments:</label>
                        <textarea class="form-control" rows="5" id="comment"></textarea>
                    </div>
                                    
                    <button class='btn btn-success' type='submit'>Approve</button>
                    <button class='btn btn-danger' type='button'>Deny</button>
                    <td><a href="delivery_table.php"><button type="button" class="btn btn-primary">Back</button></a></td>

              </div>
            </div>
          </div>
    </div>

<?php
  if($_POST) {
      if($_GET['id']) {
        $id = $_GET['id'];
        
        $sql = "UPDATE Request SET RequestStatusID = 2";
        $result = $conn->query($sql);
        if(mysqli_affected_rows($result) >0){
            echo "<script>
            alert('You approved this request, it goes to Processing status.');
            window.location.href='./delivery_table.php';
            </script>";
        }else {
            echo "wrong";
        }
        
        $conn->close();
    }
}
?>

<?php require_once('layouts/footer.php'); ?>	