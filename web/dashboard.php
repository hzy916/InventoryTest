<?php 

	require_once('inc/config.php');
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
        header('location:index.php?lmsg=true');
    }	


    require_once('./layouts/header.php'); 
    require_once('./layouts/side_bar.php'); 
    require_once('./layouts/nav.php'); 


// logout
// if(isset($_POST['but_logout'])){
//  session_destroy();

//  // Remove cookie variables
//  $days = 30;
//  setcookie ("rememberme","", time() - ($days * 24 * 60 * 60 * 1000));

//  header('Location: index.php');
// }
?>

<style>
.hidebutton{
	display: none!important;
}

.statusTH{
    float:right;
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

.highlight{
  font-weight: 400;
}
</style>

  <div class="content">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="dashboard.php">Home</a>
                </li>
                <li class="breadcrumb-item active"> Dashboard</li>
            </ol>
 
    
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="card  card-tasks">
                        <div class="card-header ">
                            <h4 class="card-title highlight">Un-Completed Shipment Request</h4>
                            <a href="DeliveryRequests/delivery_table.php" class="card-category">See all Requests  →</a>
                        </div>
                        <div class="card-body ">
                            <div class="table-full-width">
                            <table class="table">

                                        <?php
                                            $sql = "SELECT Receiver.first_name as fullname, Request_status.status_name as status_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN Receiver ON Request.ReceiverID = Receiver.receiver_id  WHERE Request.RequestStatusID != 5 LIMIT 0,2;";
                                            $result = $conn->query($sql);
                    
                                            if($result->num_rows > 0) {
                                                echo "      
                                                <thead>
                                                    <tr>
                                                        <th class='Companyrow'>Title</th>
                                                        <th class='td-actions text-right statusTH Companyrow'>
                                                            Status
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>";

                                                while($row = $result->fetch_assoc()) {
                                                    echo 
                                                    "<tr>
                                                        <td class='Companyrow'>".$row['fullname']."</td>
                                                        <td class='td-actions text-right Companyrow'><span style='color:#ffffff; margin-right:10px;text-align:center; background-color:#f5a623; padding: 6px;'>".$row['status_name']."</span></td>
                                                    </tr>";
                                                }
                                            } else {
                                                    echo "<tr><img src='assets/img/shipment_r_d_none.png' alt='no incomplete shipment request'></tr>";
                                            }
                                            ?>
                                    </tbody>
                                
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-md-6 col-lg-6">
                    <div class="card  card-tasks">
                        <div class="card-header ">
                            <h4 class="card-title highlight">Un-Completed Design Request</h4>
                            <a href="DesignRequests/design_request_table.php" class="card-category">See all Requests  →</a>
                        </div>
                        <div class="card-body ">
                            <div class="table-full-width">
                            <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="Companyrow">Title</th>
                                            <th class="td-actions text-right statusTH Companyrow">
                                                Status
                                            </th>
                                        </tr>
                                    </thead> 

                                    <tbody>
                                        <?php
                                            $sql = "SELECT CustomRequest.companyName as companyName, Request_status.status_name as status_name FROM CustomRequest JOIN Request_status ON CustomRequest.c_RequestStatusID = Request_status.status_id  WHERE CustomRequest.c_RequestStatusID = 1 LIMIT 0,2;";
                                            $result = $conn->query($sql);
                    
                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo 
                                                    "<tr>
                                                        <td class='Companyrow'>".$row['companyName']."</td>
                                                        <td class='td-actions text-right Companyrow'><span style='color:#ffffff; text-align:center; margin-right:10px; padding: 6px;background-color:#f5a623;'>".$row['status_name']."</span></td>
                                                    </tr>";
                                                }
                                            } else {
                                                echo "<tr><img src='assets/img/design_request_dashboard_none.png' alt='no incomplete shipment request'></tr>";
                                            }
                                            ?>
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
                                        <?php
                                                $sql = "SELECT * FROM pawtrails WHERE id = 27";
                                                $result = $conn->query($sql);
                                        
                                                if($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        // set styles the way you want
                                                        if($row['amount'] > 0) {
                                                            $tdStyle='background-color:#ADFF2F';
                                                            $stocktext = 'In Stock';
                                                        } else {
                                                            $tdStyle='background-color:#d4143d';
                                                            $stocktext = 'Out of Stock';
                                                        }
                                                        echo  $row['amount'];
                                                    }
                                                } else {
                                                        echo "No Data Avaliable";
                                                }
                                                ?>
                                        </td>
                                        <td class="td-actions requestTitle">
                                            <span style="text-align:center; padding: 6px; <?php echo $tdStyle; ?>"><?php echo $stocktext; ?></span>
                                        </td>
                                </tr>
                                <tr>
                                    <td class="td-actions requestTitle">PawTrails All in One</td>
                                    <td class="td-actions  requestTitle">
                                        Black
                                    </td>
                                    <td class="td-actions  requestTitle">
                                        Small
                                    </td>
                                    <td class="td-actions  requestTitle">
                                    <?php
                                            $sql = "SELECT * FROM pawtrails WHERE id = 28";
                                            $result = $conn->query($sql);
                                    
                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    // set styles the way you want
                                                    if($row['amount'] > 0) {
                                                        $tdStyle='background-color:#ADFF2F; ';
                                                        $stocktext = 'In Stock';
                                                    } else {
                                                        $tdStyle='background-color:#d4143d;';
                                                        $stocktext = 'Out of Stock';
                                                    }
                                                    echo  $row['amount'];
                                                }
                                            } else {
                                                    echo "No Data Avaliable";
                                            }
                                            ?>
                                    </td>
                                    <td class="td-actions requestTitle">
                                        <span style="text-align:center; padding: 6px; <?php echo $tdStyle; ?>"><?php echo $stocktext; ?></span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    
            <div class="card  card-tasks">  
                <div class="card-header "> 
                    <h4 class="card-title">Video Tutorials</h4>
                </div>
            
                <div class="row">
                    <div class="col-md-4 col-g-4 col-sm-4">
                        <div class="">
                            <video width="400" controls>
                                <source src="mov_bbb.mp4" type="video/mp4">
                                <source src="mov_bbb.ogg" type="video/ogg">
                                Your browser does not support HTML5 video.
                            </video>
                            <p>
                                How to register a new member?
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-g-4 col-sm-4">
                        <div class="">
                            <video width="400" controls>
                                <source src="mov_bbb.mp4" type="video/mp4">
                                <source src="mov_bbb.ogg" type="video/ogg">
                                Your browser does not support HTML5 video.
                            </video>
                            <p>
                                How to register a new member?
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-g-4 col-sm-4">
                        <div class="">
                            <video width="400" controls>
                                <source src="mov_bbb.mp4" type="video/mp4">
                                <source src="mov_bbb.ogg" type="video/ogg">
                                Your browser does not support HTML5 video.
                            </video>
                            <p>
                                How to register a new member?
                            </p>
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