
<?php

    require_once 'inc/config.php';

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
            'sql'=>"UPDATE CustomRequest SET c_RequestStatusID = 9 WHERE CustomRequest.customrequestID = '$id'",

            'alert'=>'You approved this request, it goes to approved status.',
        ),
        'design'=> array(
            //get the product id and number requested, and update inventory when request is completed. 
            'sql'=>"UPDATE CustomRequest SET c_RequestStatusID = 7 WHERE CustomRequest.customrequestID = '$id'",

            'alert'=>'You finished this design request, it goes to your archived desgin list.',
        ),
        'decline'=> array(
            'sql'=>"UPDATE CustomRequest SET c_RequestStatusID = 6 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You declined this request, it goes to declined status.',
        ),
        'delay'=> array(
            'sql'=>"UPDATE CustomRequest SET c_RequestStatusID = 3 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You delayed this request, it goes to delayed status.',
        ),
        'print'=> array(
            'sql'=> "UPDATE CustomRequest SET c_RequestStatusID = 8 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You printed this design request, it goes to ready status.',    
        ),
        'archive'=> array(
            'sql'=> "UPDATE CustomRequest SET c_is_archived = 1 WHERE CustomRequest.customrequestID = '$id'",
            'alert'=>'You archived this request, it goes to archived list.',
        ),
    );

    //to check if they use resubmit because of reloading
    if(isset($_POST['postAction']) && $_POST['randomcheck']==$_SESSION['rand']){

        $send_email_action = false;

     //   execute the related sql 
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

        //get request details
        $msg = "";
        //get all the request details
        $sql = "SELECT CustomRequest.customrequestID, CustomRequest.c_is_archived, CustomRequest.c_AdminComments, CustomRequest.voucherCode, CustomRequest.quantity, CustomRequest.companyName, CustomRequest.itemtype, CustomRequest.c_RequestEmployeeID, CustomRequest.c_RequestDate, CustomRequest.UseDate,  Request_status.status_name as status_name, tbl_users.user_name as user_name FROM CustomRequest  JOIN Request_status ON CustomRequest.c_RequestStatusID = Request_status.status_id JOIN tbl_users ON  CustomRequest.c_RequestEmployeeID = tbl_users.id WHERE CustomRequest.customrequestID = '{$id}'";               
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();

        //get itemname based on item type and company
        $itemname = $data['itemtype'].''.$data['companyName'];
        $itemtype = $data['itemtype'];
        $qty = $data['quantity'];
        
        //Create new items in inventory after design is printed
        if(isset($_POST['postAction']) && $_POST['postAction'] == 'print'){
            // //get the product id and number requested, and update inventory when request is completed. 
            $sql_createstock = "INSERT INTO pawtrails (`itemtype`,`itemname`, `amount`) VALUES ( '{$itemtype}', '{$itemname}', '{$qty}')"; 
            // //check if update stock successfully
            if ($conn->query($sql_createstock) === TRUE) {
                echo "<script>
                alert('The related product inventory is updated!'); 
                </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            } 
        }
    }

    $rand=rand();
    $_SESSION['rand']=$rand;
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
      <h1>Process Custom Design Request</h1>
  
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
                            <th>Submit date</th>
							<th class="EmployeeColumn">Employee</th>
						
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
                                    <td>".$data['c_RequestDate']."</td>
                                 
                                    <td class='EmployeeColumn'>".$data['user_name']."</td>
                                    <td>".$data['UseDate']."</td>
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
                       "<h3>Admin's Comments:  "   .$data['c_AdminComments']."</h3>";
                ?>
                <hr>
                <h4>Download Logo</h4>
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
                            "<p>Logo File Name:". $getfilename."</p>";
                            echo "<a href='download.php?file=uploads/$getfilename'>Download file</a>";
                        }    
                        ?>
                    </div> 
                <hr>
    
    
    <?php
    //only show to designers about the upload design button, and only show upload when the design is not complete
        if(($_SESSION['user_role_id'] == 4) && ($data['status_name'] != 'Design Complete')) {  ?>
            
         <form action="upload.php?id=<?php echo $_GET['id'];?>" method="POST" enctype = "multipart/form-data">
            <h4>Upload Design</h4> 
            <input type="hidden"  name="randomcheck" value="<?php echo $rand; ?>">
            <div class="col">
            <label>Design File</label>
                    <br>
                <input type = "file" name = "image" />
            </div>
            <br>
            <input type="submit" class="btn btn-primary" value="Submit Design"/>
        </form>
        <hr>
    <?php  } ?>
    <br>

    <h4>Download Design</h4> 
        <?php
        //to get the uploaded Design file name and download link
            if($_GET['id']) {
                $id = $_GET['id'];
                // $id = intval($_GET['id']);
                $sql ="SELECT DesignFilePath FROM CustomRequest WHERE customrequestID = '{$id}'";
                $result = $conn->query($sql);

                $designFile = $result->fetch_assoc();

                $designfileName = substr($designFile['DesignFilePath'], 13);
                echo 
                "<p>Design File Name: ". $designfileName."</p>";
                echo "<a href='download.php?file=DesignUpload/$designfileName'>Download Design file</a><br><br>";
            }
        ?>

        <?php
        if(($_SESSION['user_role_id'] == 1 && $data['c_is_archived'] == 0 ) || ( $_SESSION['user_role_id'] == 4 && $data['status_name'] != 'Design Complete')) {  ?>
                <form method="post" id="ciaociao">
                    <input type="hidden"  name="randomcheck" value="<?php echo $rand; ?>">
                    <div class="form-group">
                        <input type="hidden" name="postAction" value="" id="postAction"/>
                        <label for="comment">Comments:</label>
                        <textarea class="form-control" rows="5" name="commentRequest" id="comment_details"></textarea>
                        <input type="button" class='btn btn-secondary' value="Send" onclick="JavaScript:makeMyAction('comment')"/>
                    </div>
                <?php 
                //if the request status is not submitted and processing, then don't show approve, 
                    switch (true) {
                        case ($data['status_name'] == 'Submitted'):
                            echo "
                            <input type='button' class='btn btn-success operateBTN' value='Approve' onclick=\"JavaScript:makeMyAction('approve')\">
                            <input type='button' class='btn btn-danger operateBTN' value='Decline' onclick=\"JavaScript:makeMyAction('decline')\">
                            ";
                        break;
                        
                        case ($data['status_name'] == 'Delayed'):
                        if($_SESSION['user_role_id'] == 4){
                            echo "
                            <input type='button' class='btn btn-success operateBTN' value='Finish Design' onclick=\"JavaScript:makeMyAction('design')\">
                            ";
                        }
                        break;

                        case ($data['status_name'] == 'Approved'):
                            if($_SESSION['user_role_id'] == 4){
                                echo "
                                <input type='button' class='btn btn-success operateBTN' value='Finish Design' onclick=\"JavaScript:makeMyAction('design')\">
                                <input type='button' class='btn btn-danger operateBTN' value='Delay' onclick=\"JavaScript:makeMyAction('delay')\">";
                            }
                        break;

                        case ($data['status_name'] == 'Design Complete'):
                           if($_SESSION['user_role_id'] == 1){
                            echo "
                            <input type='button' class='btn btn-danger operateBTN' value='Printed- Ready' onclick=\"JavaScript:makeMyAction('print')\">
                          
                            ";
                           }
                        break;

                        case ($data['status_name'] == 'Printed' && $data['c_is_archived'] == '0'):
                            if($_SESSION['user_role_id'] == 1){
                                echo "
                                    <input type='button' class='btn btn-danger operateBTN' value='Archive' onclick=\"JavaScript:makeMyAction('archive')\">
                                ";
                            }
                        break;
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
                        //finish design button submit check if image is uploaded
                        if (document.getElementById('postAction').value == 'design'){
                <?php 
                            if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){   ?>
                            document.getElementById('ciaociao').submit();
             <?php          } else {   ?>
                               alert('No design file uploaded yet, please upload before you finish this design request.');
             <?php              }    ?>
                        } else {
                            document.getElementById('ciaociao').submit();
                        }
                        return;
                    }

                </script>

              </div>
            </div>
          </div>
    </div>

<?php 

// if ($data['status_name'] == 7) {
//     echo('<script>$("#uploadForm").addClass("hidebutton");
	
// 	</script>' );
// }
?>

<?php require_once('layouts/footer.php'); ?>	