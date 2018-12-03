<?php 
	require_once('inc/config.php');
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	

  require_once('./layouts/header.php'); 
	require_once('./layouts/side_bar.php'); 
  require_once('./layouts/nav.php'); 

?>

<style>
.hidebutton{
	display: none!important;
}

td { 
    padding: 10px;
}
.tablecontent{
  font-family: Montserrat;
  font-size: 13px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  color: #525a65;
}
.Companyrow{
  color: #a8acb2;
  font-family: Montserrat;
  font-size: 13px;
}

.requestTitle{
  letter-spacing: 0.6px;
  color: #525a65;
} 

.card .table tbody td:first-child, .card .table thead th:first-child {
    padding-left: 35px!important;
}
</style>

  <div class="content">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
      </ol>
   
      <p>Welcome, <?php echo getUserName($_SESSION['id']); ?> are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>

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

          }  else if($_SESSION['user_role_id'] == 4 ){
              //get the design request which belongs to this employee and still in submitted status.
              $sql_two = "SELECT customrequestID FROM CustomRequest WHERE c_RequestStatusID = 9 OR c_RequestStatusID = 3";
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

      
      <div class="row">
          <div class="col-md-6 col-lg-6">
              <div class="card  card-tasks">
                  <div class="card-header ">
                      <h4 class="card-title">Un-Completed Shipment Request</h4>
                      <a href="DeliveryRequests/delivery_table.php" class="card-category">See all Requests  →</a>
                  </div>
                  <div class="card-body ">
                    <div class="table-full-width">
                      <table class="table">
                          <tbody>
                              <tr>
                                  <td class="Companyrow">Title</td>
                                  <td class="td-actions text-right Companyrow">
                                    Status
                                  </td>
                              </tr>

                              <tr>
                                  <td class="tablecontent">Company Name</td>
                                  <td class="td-actions text-right tablecontent">
                                    Status
                                  </td>
                              </tr>

                              <tr>
                                  <td class="tablecontent">Company Name</td>
                                  <td class="td-actions text-right tablecontent">
                                    Status
                                  </td>
                              </tr>

                          </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- <div class="card-footer ">
                      <hr>
                      <div class="stats">
                          <i class="now-ui-icons loader_refresh spin"></i> Updated 3 minutes ago
                      </div>
                  </div> -->
              </div>
          </div>

            <div class="col-md-6 col-lg-6">
              <div class="card  card-tasks">
                  <div class="card-header ">
                      <h4 class="card-title">Un-Completed Design Request</h4>
                      <p class="card-category">See all Requests  →</p>
                  </div>
                  <div class="card-body ">
                    <div class="table-full-width">
                      <table class="table">
                          <tbody>
                              <tr>
                                  <td class="Companyrow">Title</td>
                                  <td class="td-actions text-right Companyrow">
                                    Status
                                  </td>
                              </tr>

                              <tr>
                                  <td class="tablecontent">Company Name</td>
                                  <td class="td-actions text-right tablecontent">
                                    Status
                                  </td>
                              </tr>

                              <tr>
                                  <td class="tablecontent">Company Name</td>
                                  <td class="td-actions text-right tablecontent">
                                    Status
                                  </td>
                              </tr>

                          </tbody>
                      </table>
                    </div>
                  </div>

              </div>
          </div>
    </div>

      <div class="row">
         <div class="col-md-12 col-lg-12">
              <div class="card  card-tasks">
                  <div class="card-header ">
                      <h4 class="card-title">Inventory Overview</h4>
                      <p class="card-category">See all Inventory  →</p>
                  </div>
                  <div class="card-body ">
                    <div class="table-full-width">
                      <table class="table">
                          <tbody>
                              <tr>
                                  <td class="td-actions  requestTitle">Product Name</td>
                                  <td class="td-actions  requestTitle">
                                    Color
                                  </td>
                                  <td class="td-actions requestTitle">
                                    Size
                                  </td>
                                  <td class="td-actions  requestTitle">
                                  Stock on Hand
                                  </td>
                                  <td class="td-actions requestTitle">
                                  Status
                                  </td>
                              </tr>

                              <tr>
                                  <td class="td-actions requestTitle">PawTrails All in One</td>
                                  <td class="td-actions  requestTitle">
                                    Red
                                  </td>
                                  <td class="td-actions  requestTitle">
                                     Small
                                  </td>
                                  <td class="td-actions  requestTitle">
                                      0
                                  </td>
                                  <td class="td-actions requestTitle">
                                      Out of Stock
                                  </td>
                              </tr>


                          </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="card-footer ">
                      <hr>
                      <div class="stats">
                          <i class="now-ui-icons loader_refresh spin"></i> Updated 3 minutes ago
                      </div>
                  </div>
              </div>
          </div>
        </div>
</div>


    <!-- /.container-fluid-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--   Core JS Files   -->
<script src="/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="/assets/js/plugins/bootstrap-switch.js"></script>


<!--  Notifications Plugin    -->
<script src="/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="/assets/js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="/assets/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.showNotification();

    });
</script>

<?php  

if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3  ) {
	echo('<script>$("#createBtn").addClass("hidebutton");
	$(".OperationColumn").addClass("hidebutton");
	</script>' );
}



?>
<?php require_once('./layouts/footer.php'); ?>	