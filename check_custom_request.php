
<?php

    require 'inc/config.php';

    if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
    {
        header('location:index.php?lmsg=true');
        exit;
    }		

    require_once('layouts/header.php'); 
    require_once('layouts/left_sidebar.php');   

if($_GET['id']) {
    $id = $_GET['id'];

    $myCommReq='';
    if(!empty($_POST['commentRequest'])){
        $myCommReq=mysqli_real_escape_string($conn,$_POST['commentRequest']);
    }

    $myArr=array(
        'comment'=> array(
            'sql'=>"UPDATE CustomRequest SET c_AdminComments = '".$myCommReq."' WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You send comments on this request',
        ),
        'approve'=> array(
            //get the product id and number requested, and update inventory when request is completed. 
            'sql'=>"UPDATE CustomRequest SET c_RequestStatusID = 2 WHERE CustomRequest.customrequestID = '$id'",

            'alert'=>'You approved this request, it goes to processing status.',
        ),
        'decline'=> array(
            'sql'=>"UPDATE CustomRequest SET c_RequestStatusID = 6 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You declined this request, it goes to declined status.',
        ),
        'delay'=> array(
            'sql'=>"UPDATE CustomRequest SET c_RequestStatusID = 3 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You delayed this request, it goes to delayed status.',
        ),
        'finish'=> array(
            'sql'=> "UPDATE CustomRequest SET c_RequestStatusID = 5 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You finished this request, it goes to completed status.',
        ),
        'archive'=> array(
            'sql'=> "UPDATE CustomRequest SET c_is_archived = 1 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You archived this request, it goes to archived list.',
        ),
    );

    if(isset($_POST['postAction'])) {
        $send_email_action = false;

        if($_POST['postAction'] == 'approve'){
            // //get the product id and number requested, and update inventory when request is completed. 
            // $sql_updatestock = "UPDATE pawtrails JOIN Pawtrails_Request_junction ON pawtrails.id = Pawtrails_Request_junction.pawtrails_id && Pawtrails_Request_junction.request_id = '$id' SET pawtrails.amount = pawtrails.amount - Pawtrails_Request_junction.Qty"; 
        
            // //check if update stock successfully
            // if ($conn->query($sql_updatestock) === TRUE) {
            //     echo "<script>
            //     alert('The related product inventory is updated!'); 
            //     </script>";
            //     // include 'mail.php';
            
            // } else {
            //     echo "Error updating record: " . $conn->error;
            // } 
        }

    
        $sql_udpate = $myArr[$_POST['postAction']]['sql'];
        if ($conn->query($sql_udpate) === TRUE) {
           
            //alert notifications about status change
            echo "<script>
            alert('".$myArr[$_POST['postAction']]['alert']."');
            </script>";
           
            $send_email_action = true;

        } else {
            echo "Error updating record: " . $conn->error;
        } 
    }
 
        $msg = "";
        //get all the request details
        $sql = "SELECT CustomRequest.customrequestID, CustomRequest.c_is_archived, CustomRequest.c_AdminComments, CustomRequest.voucherCode, CustomRequest.quantity, CustomRequest.companyName, CustomRequest.itemtype, CustomRequest.c_RequestEmployeeID, CustomRequest.c_RequestDate, CustomRequest.UseDate,  Request_status.status_name as status_name, tbl_users.user_name as user_name FROM CustomRequest  JOIN Request_status ON CustomRequest.c_RequestStatusID = Request_status.status_id JOIN tbl_users ON  CustomRequest.c_RequestEmployeeID = tbl_users.id WHERE CustomRequest.customrequestID = '{$id}'";               
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        //  if(isset($send_email_action)){
        //       //sending emails after status changed
        //         $output = $data['user_name'] . '  request status changed to ' .$data['status_name'] . ' and the request ID is '.$id ;  
        //         $to = $data['email'];
        //         $subject = "Request Status changed";
        //         $headers = "From: test@test.com" . "\r\n" .
        //         "CC: somebodyelse@example.com";    
        //         mail($to,$subject,$output,$headers);
        //   //end of sending emails after status changed   
        //  }
    }
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
             <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Customized Item Requests</li>
      </ol>
      <h1>Process Custom Request</h1>
  
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
        <h2>Request Details</h2>
        <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        </tr>
					</thead>
		
						<tbody>
							<?php
                                echo
                                    "<tr>
                                    <td>".$data['customrequestID']."</td>
                                    <td>".$data['itemtype']."  ".$data['companyName']."</td>
                                    <td>".$data['UseDate']."</td>
                                    <td class='EmployeeColumn'>".$data['user_name']."</td>
                                    <td>".$data['c_RequestDate']."</td>
                                    
                                    
                                    <td>".$data['quantity']."</td>
                                    <td>".$data['voucherCode']."</td>
                                    <td>".$data['status_name']."</td> 
                                </tr>
                                ";
							?>
					</tbody>
				</table>
            
                <?php
                       echo 
                       "<p>Last Comments:  "   .$data['c_AdminComments']."</p>";
                ?>
                <h4>Logo download</h4>
                    <p><?php echo $msg ?></p>
                    <div class="table-responsive">
                    <?php
                  
                  
                        if($_GET['id']) {
                            $id = $_GET['id'];
                            // $id = intval($_GET['id']);
                            $sql ="SELECT uploadLogo FROM CustomRequest WHERE customrequestID = '{$id}'";
                            $result = $conn->query($sql);
        
                            $uploadFile = $result->fetch_assoc();

                            $getfilename = substr($uploadFile['uploadLogo'], 8);
                            echo 
                            "<p>". $getfilename."</p>";
                           echo "<a href='download.php?file=$getfilename'>Download file</a>";
                    
                        }
                       
                        ?>
                    </div>

                    
        <?php
        if($_SESSION['user_role_id'] == 1 ) {  ?>
                <form method="post" id="ciaociao">
                    <div class="form-group">
                        <input type="hidden" name="postAction" value="" id="postAction"/>
                        <label for="comment">Comments:</label>
                        <textarea class="form-control" rows="5" name="commentRequest" id="comment_details"></textarea>
                        <input type="button" class='btn btn-secondary' value="Send" onclick="JavaScript:makeMyAction('comment')"/>
                    </div>
                <?php 
                //if the request status is not submitted and processing, then don't show approve, 
             
                    if($data['status_name'] == 'Submitted'){
                       echo "
                       <input type='button' class='btn btn-success operateBTN' value='Approve' onclick=\"JavaScript:makeMyAction('approve')\">
                       <input type='button' class='btn btn-danger operateBTN' value='Decline' onclick=\"JavaScript:makeMyAction('decline')\">
                       <input type='button' class='btn btn-warning operateBTN' value='Delay' onclick=\"JavaScript:makeMyAction('delay')\">        
                       ";
                    } else if($data['status_name'] == 'Delayed'){
                        echo "
                        <input type='button' class='btn btn-success operateBTN' value='Approve' onclick=\"JavaScript:makeMyAction('approve')\">
                        <input type='button' class='btn btn-danger operateBTN' value='Decline' onclick=\"JavaScript:makeMyAction('decline')\">";
                    } else if($data['status_name'] == 'Processing'){
                        echo "
                        <input type='button' class='btn btn-danger operateBTN' value='Finish' onclick=\"JavaScript:makeMyAction('finish')\">
                         ";
                    }else if($data['status_name'] == 'Completed' && $data['c_is_archived'] == '0'){
                        echo "
                        <input type='button' class='btn btn-info operateBTN' value='Archive' onclick=\"JavaScript:makeMyAction('archive')\">
                         ";
                    } else if($data['c_is_archived'] == '1'){
                        echo "";
                    }
                } 
                //to give different go back link based on which page user is
                    if($data['c_is_archived'] == '1'){
                        $link = "archived_custom_request.php";
                    } else {
                        $link = "custom_request_table.php";
                    }
                            echo "<td><a href='$link'><button type='button' class='btn btn-primary'>Back</button></a></td>";
                    ?> 
                </form>

                <script language="JavaScript">
                    function makeMyAction(val){
                        //  alert(val);
                        document.getElementById('postAction').value = val;
                        document.getElementById('ciaociao').submit();
                        return;
                    }
                </script>

              </div>
            </div>
          </div>
    </div>

<?php require_once('layouts/footer.php'); ?>	