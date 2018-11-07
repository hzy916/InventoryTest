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
  
        $sql = "SELECT Request.RequestID, Request.RequestDate, Request.ShipDate, Request_status.status_name, tbl_users.user_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE Request.RequestID = '{$id}'";

        $result = $conn->query($sql);
        
        $data = $result->fetch_assoc();
       
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
                    
                                <?php    
                                    if($result_two->num_rows > 0) {
                                        while($row_two = $result_two->fetch_assoc()) {
                                            echo 
                                            "<div>
                                            <table>
                                                <tr>
                                                    <td> <label><strong>Receiver ID:</strong> </label> ".$row_two['receiver_id']."</td>
                                                    <td><strong>Company Name:</strong> ".$row_two['company_name']."</td>
                                                </tr>
                                              
                                                <tr>
                                                    <td><strong>First Name:</strong> ".$row_two['first_name']."</td>
                                                    <td><strong>Last Name:</strong> ".$row_two['last_name']."</td>
                                                </tr>

                                                <tr>
                                                    <td> <label><strong>Phone Number:</strong> </label>".$row_two['phone']."</td>
                                                </tr>

                                                <tr>
                                                    <td> <label><strong>address1:</strong> </label>".$row_two['address1']."</td>
                                                    <td> <label><strong>address2:</strong> </label>".$row_two['address2']."</td>
                                                </tr>
                                                <tr>
                                                    <td> <label><strong>address 3:</strong> </label>".$row_two['address3']."</td>
                                                    <td> <label><strong>City:</strong> </label>".$row_two['city']."</td>
                                                </tr>

                                                <tr>
                                                    <td> <label><strong>Country:</strong> </label>".$row_two['country']."</td>
                                                    <td> <label><strong>Postal code:</strong> </label>".$row_two['postalcode']."</td>
                                                </tr>
                                    
                                            </table>
                                            </div>";
                                        }
                                    }else {
                                        echo "Error " . $sql_two . ' ' . $conn->connect_error;
                                    }	
                                ?>
            
                    </div>

                <form method="post">
                    <div class="form-group">
                        <label for="comment">Comments:</label>
                        <textarea class="form-control" rows="5" id="comment_details"></textarea>
                        <input type="submit" name="submit" value="Send" id="submit"/>
                    </div>

                    <input type="submit" class='btn btn-success' value="Approve" name="approveRequest">
                    <input type="submit" class='btn btn-danger' value="Decline" name="declineRequest">
                    <input type="submit" class='btn btn-warning' value="Delay" name="delayRequest">
                   
                    <td><a href="delivery_table.php"><button type="button" class="btn btn-primary">Back</button></a></td>
                </form>

              </div>
            </div>
          </div>
    </div>

<?php
//get comments and update in database

if(isset($_POST['comment_details'])) {
    if($_GET['id']) {
        $id = $_GET['id'];
        
      $sql_udpate = "UPDATE Request SET Comments = " .$_POST['comment_details']. " WHERE Request.RequestID = '$id'";
      if ($conn->query($sql_udpate) === TRUE) {
        echo "<script>
        alert('You approved this request, it goes to processing status.');
        window.location.href='./delivery_table.php';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    } 
        $conn->close();
    }
}

//approve the request,  it goes to processing status
if(isset($_POST['approveRequest'])) {
      if($_GET['id']) {
        $id = $_GET['id'];
        
      $sql_udpate = "UPDATE Request SET RequestStatusID = 2 WHERE Request.RequestID = '$id'";
      if ($conn->query($sql_udpate) === TRUE) {
        echo "<script>
        alert('You approved this request, it goes to processing status.');
        window.location.href='./delivery_table.php';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
        
        $conn->close();
    }
}

//decline the request
if(isset($_POST['declineRequest'])) {
    if($_GET['id']) {
      $id = $_GET['id'];
      
    $sql_decline = "UPDATE Request SET RequestStatusID = 6 WHERE Request.RequestID = '$id'";
    if ($conn->query($sql_decline) === TRUE) {
      echo "<script>
      alert('You declined this request, it goes to declined status.');
      window.location.href='./delivery_table.php';
      </script>";
  } else {
      echo "Error updating record: " . $conn->error;
  }
      
      $conn->close();
  }
}

//
//decline the request
if(isset($_POST['delayRequest'])) {
    if($_GET['id']) {
      $id = $_GET['id'];
      
    $sql_decline = "UPDATE Request SET RequestStatusID = 3 WHERE Request.RequestID = '$id'";
    if ($conn->query($sql_decline) === TRUE) {
      echo "<script>
      alert('You delayed this request, it goes to delayed status.');
      window.location.href='./delivery_table.php';
      </script>";
  } else {
      echo "Error updating record: " . $conn->error;
  }
      
      $conn->close();
  }
}

?>

<?php require_once('layouts/footer.php'); ?>	