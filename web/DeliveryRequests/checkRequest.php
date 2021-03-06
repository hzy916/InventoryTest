<?php

    require_once('../inc/config.php');
    

    if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
    {
        header('location:index.php?lmsg=true');
        exit;
    }		


	require_once('../layouts/header.php'); 
	require_once('../layouts/side_bar.php'); 
    require_once('../layouts/nav.php'); 
      
    include '../mail.php';

    $send_email_action = false;

if($_GET['id']) {
    $id = $_GET['id'];

    $myCommReq='';
    if(!empty($_POST['commentRequest'])){
        $myCommReq=mysqli_real_escape_string($conn,$_POST['commentRequest']);
    }

    $myArr=array(
        'comment'=> array(
            'sql'=>"UPDATE Request SET Comments = '".$myCommReq."' WHERE Request.RequestID = '$id'",
            'alert'=>'You send comments about this request',
        ),
        'approve'=> array(
            //get the product id and number requested, and update inventory when request is completed. 
            'sql'=>"UPDATE Request SET RequestStatusID = 2 WHERE Request.RequestID = '$id'",

            'alert'=>'You approved this request, it goes to processing status.',
        ),
        'decline'=> array(
            'sql'=>"UPDATE Request SET RequestStatusID = 6 WHERE Request.RequestID = '$id'",
            'alert'=>'You declined this request, it goes to declined status.',
        ),
        'delay'=> array(
            'sql'=>"UPDATE Request SET RequestStatusID = 3 WHERE Request.RequestID = '$id'",
            'alert'=>'You delayed this request, it goes to delayed status.',
        ),
        'finish'=> array(
            'sql'=> "UPDATE Request SET RequestStatusID = 5 WHERE Request.RequestID = '$id'",
            'alert'=>'You finished this request, it goes to completed status.',
        ),
        'archive'=> array(
            'sql'=> "UPDATE Request SET is_archived = 1 WHERE Request.RequestID = '$id'",
            'alert'=>'You archived this request, it goes to archived list.',
        ),
    );


    
        if(isset($_POST['postAction']) && $_POST['randomcheck']==$_SESSION['rand']){
            // $send_email_action = false;

            if($_POST['postAction'] == 'approve'){
                //get the product id and number requested, and update inventory when request is completed. 
                $myUpdate=false;
             
                //query to find the items id and qty requested in one request
                $sql_checkstock = "SELECT Pawtrails_Request_junction.pawtrails_id, Pawtrails_Request_junction.Qty, pawtrails.amount FROM Pawtrails_Request_junction, pawtrails WHERE pawtrails.id=Pawtrails_Request_junction.pawtrails_id AND Pawtrails_Request_junction.request_id='$id' AND pawtrails.amount < Pawtrails_Request_junction.Qty";

                $checkStock = mysqli_query($conn, $sql_checkstock);

                if(mysqli_num_rows($checkStock) > 0){
                    echo "<script>alert('updating stock failed, there are items out of stock in this request');</script>";
                } else{
                     //update stock query
                    $sql_updatestock = "UPDATE pawtrails JOIN Pawtrails_Request_junction ON pawtrails.id = Pawtrails_Request_junction.pawtrails_id && Pawtrails_Request_junction.request_id = '$id' SET pawtrails.amount = pawtrails.amount - Pawtrails_Request_junction.Qty"; 
                    //check if update stock successfully
                    if ($conn->query($sql_updatestock) === TRUE) {
                        $myUpdate=true;
                        echo "<script>
                        alert('The related product inventory is updated!'); 
                        </script>";

                    } else {
                        echo "Error updating record: " . $conn->error;
                    } 
                    //if approve is success change submitted to processing
                }
            }else{
                $myUpdate=true;
            }

            //update request status and alert user about the status change
            if($myUpdate) {
                //update reqeust status 
                $sql_udpate = $myArr[$_POST['postAction']]['sql'];
                if ($conn->query($sql_udpate) === TRUE) {
                    //alert notifications about the status change
                    echo "<script>
                    alert('".$myArr[$_POST['postAction']]['alert']."');
                    </script>";
                    
                    //find the email receivers
                    $receivers = array();

                    $send_email_action = $_POST['postAction'];

                } else {
                    echo "Error updating record: " . $conn->error;
                } 
            }
        }


        //get all the request details

        $sql = "SELECT Request.RequestID, Request.RequestDate, Request_status.status_name, tbl_users.user_name,tbl_users.email FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE Request.RequestID = '{$id}'";

        //error handling method
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else{
            $data = "No data available";
        }
 
        $msg = "";

        //get receiver details
        $sql_two = "SELECT * FROM Receiver JOIN Request ON Receiver.receiver_id = Request.ReceiverID  WHERE Request.RequestID = '{$id}' ";
        $result_two = $conn->query($sql_two);  

        //get request item list
        $sql_three = "SELECT pawtrails.itemname as name, pawtrails.id as id, pawtrails.color as color, pawtrails.size as size,  Pawtrails_Request_junction.Qty as quantity FROM pawtrails, Pawtrails_Request_junction WHERE Pawtrails_Request_junction.request_id = '{$id}' AND Pawtrails_Request_junction.pawtrails_id = pawtrails.id" ;
    
        $result_three = $conn->query($sql_three);  
      

        //send email after getting info
        if($send_email_action){
            //if it is comment or archive action, we don't send email notifications
            if($send_email_action == 'comment' || $send_email_action == 'archive' ){
                $send_email_action = false;
            } else{
                //find the subject based on status change
                $subject = array(
                    'approve' => 'Approved Request',
                    'decline' => 'Declined Request',
                    'finish' => 'Completed Request',
                    'delay' => 'Delayed Request',
                    // 'comment' => 'New Comment about Request',
                );
                $body = array(
                    'approve' => 'The request id ' .$data['RequestID']. ' is approved by the admin.',
                    'decline' => 'The request id' .$data['RequestID']. ' is declined by the admin.',
                    'finish' => 'The request id' .$data['RequestID']. ' is completed by the admin.',
                    'delay' => 'The request id' .$data['RequestID']. ' is delayed by the admin.',
                    // 'comment' => 'The request id' .$data['RequestID']. ' is commented by the admin.',
                
                );

                $subject = $subject[$send_email_action];
                $body = $body[$send_email_action];

                $receivers[$data['email']]= $data['user_name'];
                sendMail($receivers,$subject,$body);
            }
        }
     
    }

    //create a random string and save it in session
    $rand=rand();
    $_SESSION['rand']=$rand;
?>
     <!-- Breadcrumbs-->
     <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard.php">Dashboard<i class="fa fa-angle-right"></i></a>
        </li> 
        <br>
        <li class="breadcrumb-item active"> Request Details</li>
      </ol>

  <div class="content-wrapper">
    <div class="container-fluid">
 
      <h2>Process Delivery Request</h2>
  
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
        <h2>Request Details</h2>
        <div class="card-body">
			<div class="table-responsive" cellspacing="10">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Request ID</th>
							<th>Submit date</th>
						
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
                          
                                <tbody>
                                <?php
                                    $doButtonOperation=false;
                                    if($result_three->num_rows > 0) {
                                        echo "
                                        <thead>
                                            <tr>
                                                <th>item id</th>
                                                <th>item Name</th>
                                                <th>size</th>
                                                <th>color</th>
                                                <th>Quantity</th>
                                            
                                            </tr>
                                        </thead>";

                                        $doButtonOperation=true;
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
                                        echo "<tr><span class='errorMessage'>No data available</span></tr>";
                                        // echo "Error " . $sql_three . ' ' . $conn->connect_error;
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
                                                    <td><strong>Full Name:</strong> ".$row_two['first_name']."</td>
                                                </tr>

                                                <tr>
                                                    <td> <label><strong>Phone Number:</strong> </label>".$row_two['phone']."</td>
                                                    <td> <label><strong>Receiver Email:</strong> </label>".$row_two['receiver_email']."</td>
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
                                                <tr>
                                                    <td> <label><strong>Submitted Comments:</strong> </label>".$row_two['Comments']."</td>
                                                    <td> </td>
                                                </tr>
                                        
                                            </table>
                                            </div>";
                                        }
                                    }else {
                                        echo "<tr><span class='errorMessage'>No data available</span></tr>";
                                        // echo "Error " . $sql_two . ' ' . $conn->connect_error;
                                    }	
                                ?>
            
                    </div>

        <?php
        if($_SESSION['user_role_id'] == 1 ) {  ?>
                <form method="post" id="ciaociao">
                    <input type="hidden"  name="randomcheck" value="<?php echo $rand; ?>">
                    <div class="form-group commentDiv">
                        <input type="hidden" name="postAction" value="" id="postAction"/>
                        <label class="commentstitle" for="comment">Comments:</label>
                        <br>
                        <textarea class="form-group" rows="4" cols="50" name="commentRequest" id="comment_details"></textarea>
                        <br>
                        <input type="button" class='btn btn-secondary' value="Send" onclick="JavaScript:makeMyAction('comment')"/>
                    </div>

                <?php 
                //if the request status is not submitted and processing, then don't show approve, 
                    switch($data['status_name']) {
                        case 'Submitted':
                            //if there is query error on sql_three, then there is no item in the item list, we only allow admin to decline or delay the request
                            if($doButtonOperation) {
                                echo "<input type='button' class='btn btn-success operateBTN' value='Approve' onclick=\"JavaScript:makeMyAction('approve')\">";
                            }
                            echo "
                            <input type='button' class='btn btn-danger operateBTN' value='Decline' onclick=\"JavaScript:makeMyAction('decline')\">
                            <input type='button' class='btn btn-warning operateBTN' value='Delay' onclick=\"JavaScript:makeMyAction('delay')\">        
                            ";
                        break;

                        case 'Delayed': 
                            if($doButtonOperation) { 
                                echo "<input type='button' class='btn btn-success operateBTN' value='Approve' onclick=\"JavaScript:makeMyAction('approve')\">";
                            }
                            echo "<input type='button' class='btn btn-danger operateBTN' value='Decline' onclick=\"JavaScript:makeMyAction('decline')\">";
                        break;

                        case 'Processing':  
                            if($doButtonOperation) { 
                                echo "<input type='button' class='btn btn-danger operateBTN' value='Finish' onclick=\"JavaScript:makeMyAction('finish')\">";
                            }
                        break;

                        case 'Completed':    
                            echo "<input type='button' class='btn btn-info operateBTN' value='Archive' onclick=\"JavaScript:makeMyAction('archive')\">";
                        break; 
                    }

                    ?>
        <?php  } ?> 
                  
                    <td><a href="shipment_list.php?mystatus=<?php echo strtolower($data['status_name']);?>"><button type="button" class="btn btn-primary">Back</button></a></td>
                   
                </form>

                <script language="JavaScript">
                 function makeMyAction(val){
                    //   alert(val);
                     document.getElementById('postAction').value = val;
                     document.getElementById('ciaociao').submit();
                     return;
                 }
                </script>

              </div>
            </div>
          </div>
    </div>
</div>

<?php require_once('../layouts/footer.php'); ?>	