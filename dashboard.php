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

<style>
.hidebutton{
	display: none!important;
}

</style>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
		<li class="breadcrumb-item active">Messages</li>
      </ol>
      <h1>Welcome to Dashboard</h1>
      <hr>
      <p><?php echo getUserName($_SESSION['id']); ?> are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>

      <?php
      		//only visible to admin and editor
          if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3  ) {?>
		
          <p>You can:</p>
          <a class="btn btn-dark" href="delivery_request.php">Submit Delivery Request</a>
          <!-- <a class="btn btn-secondary" href="return_request.php">Submit Return Request</a> -->
          
		  <?php }?>


        <?php
      		//only visible to admin and editor
          if($_SESSION['user_role_id'] == 1 ) {
            //get the request which are still in submitted status.
              $sql = "SELECT RequestID FROM Request WHERE RequestStatusID = 1";
              $result = $conn->query($sql);	
              $count =  $result->num_rows;

              //get the design request which are still in submitted status.
              $sql_two = "SELECT customrequestID FROM CustomRequest WHERE c_RequestStatusID = 1";
              $result_two = $conn->query($sql_two);	
              $count_two =  $result_two->num_rows;

          } else {
             //get the request which belongs to this employee and still in submitted status.
             $sql = "SELECT RequestID FROM Request WHERE RequestStatusID = 1 AND RequestEmployeeID = ". $_SESSION['id'];
             $result = $conn->query($sql);	
             $count =  $result->num_rows;

            //get the design request which belongs to this employee and still in submitted status.
            $sql_two = "SELECT customrequestID FROM CustomRequest WHERE c_RequestStatusID = 1 AND c_RequestEmployeeID = ". $_SESSION['id'];
            $result_two = $conn->query($sql_two);	
            $count_two =  $result_two->num_rows;
          }
          ?>

       
          <!-- Icon Cards-->
        <div class="row" style="margin-top:1em;">
          <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
              <?php
          
              ?>
                  <div class="mr-5"><?php echo $count ?> Pending Delivery Requests.</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="delivery_table.php">
                  <span class="float-left">View Details</span>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                  <div class="mr-5"><?php echo $count_two ?>  Design Requests!</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="custom_request_table.php">
                  <span class="float-left">View Details</span>
                </a>
              </div>
            </div> 

     
            <!-- <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="mr-5">!</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">View Details</span>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="mr-5">11 New Tasks!</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">View Details</span>
                </a>
              </div>
            </div>
          </div> -->
    </div>


    <!-- /.container-fluid-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php  

if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3  ) {
	echo('<script>$("#createBtn").addClass("hidebutton");
	$(".OperationColumn").addClass("hidebutton");
	</script>' );
}

?>
<?php require_once('layouts/footer.php'); ?>	