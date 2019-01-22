<?php 

	require_once('inc/config.php');
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
        // echo "session not set";
        header('location:index.php?lmsg=true');
    }	


    require_once('./layouts/header.php'); 
    require_once('./layouts/side_bar.php'); 
    require_once('./layouts/nav.php'); 

// Check user login or not
   //log out
    if(isset($_GET['logout']) && $_GET['logout'] == true)
    {
        session_destroy();
        header("location:index.php");
        exit;
    }
    if(isset($_GET['lmsg']) && $_GET['lmsg'] == true)
    {
        $errorMsg = "Login required to access dashboard";
    }
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
  color: #525a65;
  font-family: Montserrat;
  font-size: 13px!important;
  text-transform:none!important;
}

.requestTitle{
  letter-spacing: 0.6px;
  color:  #a8acb2;
  font-size:13px!important;
} 

.card .table tbody td:first-child, .card .table thead th:first-child {
    padding-left: 35px!important;
}

.highlight{
  font-weight: 400;
  text-transform:none;
}

.table_bottom_custom{
    margin-bottom:0px;
}

.breadcrumb-item.active {
    text-transform: none!important;
}

.grey_title > td{
    color: #a8acb2;
}

.text_right{
    text-align:right!important;
}

.no_top_border{
    border-top:none!important;
}

.text_color{
    color: #525a65!important;
}

.th_top{
    border-top: 1px solid #e9ecef;
}
.custom_table_bottom{
    margin-bottom:0px!important;
}
.video_box{
    padding:25px;
}
.video_container{
    width:100%;
    margin:0 10px;
}
.margin_left{
    margin-left:1rem!important;
}

.table .td-actions {
    margin-right: 20px;
}

.responsive_table{
    overflow-x:auto;
}
.stock_div{
    text-align:center; 
    padding: 6px 20px; 
    color: #fff;
    width:120px;
}

.status_div{
    color:#ffffff; 
    margin-right:10px;
    text-align:center; 
    background-color:#f5a623;  
    padding: 6px 10px;
    width:120px;
    float:right;
}

</style>
      <!-- Breadcrumbs-->
    <div class="full_width">
        <ol class="breadcrumb nav_border_bottom">
            <li class="breadcrumb-item">
            <a href="dashboard.php">Home<i class="fa fa-angle-right"></i></a>
            </li>
            <br>
            <li class="breadcrumb-item active"> Dashboard</li>
        </ol>
    </div>
  <div class="content">
 
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="card  card-tasks">
                        <div class="card-header ">
                            <table class="table table-full-width custom_table_bottom">
                                <tr>
                                    <td class="no_top_border"><h4 class="card-title text_color">Un-Completed Shipment Request</h4></td>
                                    <td class="no_top_border text_right"><a href="./DeliveryRequests/shipment_list.php" class="card-category">See all Requests  →</a></td>
                                </tr>
                            </table>
                        </div>
                    
                        <div class="card-body ">
                            <div class="table-full-width">
                                <table class="table table_bottom_custom">
                                   
                                      
                                        <?php
                                            $sql = "SELECT Receiver.first_name as fullname, Request_status.status_name as status_name FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN Receiver ON Request.ReceiverID = Receiver.receiver_id  WHERE Request.RequestStatusID != 5 LIMIT 0,2;";
                                            $result = $conn->query($sql);
                    
                                            if($result->num_rows > 0) {
                                                echo "      
                                                <thead class='th_top'>
                                                    <tr>
                                                        <th class='Companyrow'>Title</th>
                                                        <th class='td-actions statusTH Companyrow'>
                                                            Status
                                                        </th>
                                                    </tr>
                                                </thead> 
                                                <tbody>
                                               ";

                                                while($row = $result->fetch_assoc()) {
                                                    echo 
                                                    "<tr>
                                                        <td class='Companyrow'>".$row['fullname']."</td>
                                                        <td class='td-actions text-right Companyrow'><div class='status_div'>".$row['status_name']."</div></td>
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
                            <table class="table table-full-width custom_table_bottom">
                                <tr>
                                    <td class="no_top_border"><h4 class="card-title text_color">Un-Completed Design Request</h4></td>
                                    <td class="no_top_border text_right"><a href="./DesignRequests/design_request_table.php" class="card-category">See all Requests  →</a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body ">
                            <div class="table-full-width">
                            <table class="table table_bottom_custom">
                                    <tbody>
                                        <?php
                                            $sql = "SELECT CustomRequest.companyName as companyName, Request_status.status_name as status_name FROM CustomRequest JOIN Request_status ON CustomRequest.c_RequestStatusID = Request_status.status_id  WHERE CustomRequest.c_RequestStatusID = 1 LIMIT 0,2;";
                                            $result = $conn->query($sql);
                    
                                            if($result->num_rows > 0) {
                                                echo"
                                                <thead class='th_top'>
                                                    <tr>
                                                        <th class='Companyrow'>Title</th>
                                                        <th class='td-actions text-right statusTH Companyrow'>
                                                            Status
                                                        </th>
                                                    </tr>
                                                </thead> 
                                                <tbody>
                                                ";

                                                while($row = $result->fetch_assoc()) {
                                                    echo 
                                                    "<tr>
                                                        <td class='Companyrow'>".$row['companyName']."</td>
                                                        <td class='td-actions text-right Companyrow'><div class='status_div'>".$row['status_name']."</div></td>
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
                        <table class="table table-full-width">
                            <tr>
                                <td class="no_top_border"><h4 class="card-title text_color">Inventory Overview</h4></td>
                                <td class="no_top_border text_right"><a href="./inventory/inventory.php" class="card-category">See all Inventory  →</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-body ">
                        <div class="table-full-width responsive_table">
                            <table class="table table_bottom_custom">
                                <tbody>
                                    <tr class="grey_title">
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
                                        <td class="td-actions Companyrow">PawTrails All in One</td>
                                        <td class="td-actions Companyrow">
                                            Red
                                        </td>
                                        <td class="td-actions Companyrow">
                                            Medium
                                        </td>
                                        <td class="td-actions Companyrow">
                                            <?php
                                                    $sql = "SELECT * FROM pawtrails WHERE color = 'red' AND size = 'medium'";
                                                    $result = $conn->query($sql);
                                            
                                                    if($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()) {
                                                            // set styles the way you want
                                                            if($row['amount'] > 0) {
                                                                $tdStyle='background-color:#8ac44a;';
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
                                            <td class="td-actions">
                                                <div class="stock_div" style="<?php echo $tdStyle; ?>"><?php echo $stocktext; ?></div>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td class="td-actions Companyrow">PawTrails All in One</td>
                                        <td class="td-actions Companyrow">
                                            Black
                                        </td>
                                        <td class="td-actions Companyrow">
                                            Small
                                        </td>
                                        <td class="td-actions Companyrow">
                                        <?php
                                                $sql = "SELECT * FROM pawtrails WHERE color = 'black' AND size = 'small'";
                                                $result = $conn->query($sql);
                                        
                                                if($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        // set styles the way you want
                                                        if($row['amount'] > 0) {
                                                            $tdStyle='background-color:#8ac44a; ';
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
                                        <td class="td-actions Companyrow">
                                            <div class="stock_div" style="<?php echo $tdStyle; ?>"><?php echo $stocktext; ?></div>
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
                    <h4 class="card-title text_color margin_left">Video Tutorials</h4>
                </div>
                <div class="video_container">                         
                    <div class="row">
                        <div class="col-md-4 col-g-4 col-sm-4">
                            <div class="video_box">
                                <video width="100%" controls>
                                    <source src="https://www.youtube.com/watch?v=hT7DSOh3mHM" type="video/mp4">
                                    <source src="https://www.youtube.com/watch?v=hT7DSOh3mHM" type="video/ogg">
                                    Your browser does not support HTML5 video.
                                </video>
                                <p class="text_color">
                                    How to register a new member?
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4 col-g-4 col-sm-4">
                            <div class="video_box">
                                <video width="100%" controls>
                                    <source src="https://www.youtube.com/watch?v=QIcuS2HWAuY" type="video/mp4">
                                    <source src="https://www.youtube.com/watch?v=QIcuS2HWAuY" type="video/ogg">
                                    Your browser does not support HTML5 video.
                                </video>
                                <p class="text_color">
                                    How to register a new member?
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4 col-g-4 col-sm-4">
                            <div class="video_box">
                                <video width="100%" controls>
                                    <source src="https://www.youtube.com/watch?v=_X9dmWPA-dw" type="video/mp4">
                                    <source src="https://www.youtube.com/watch?v=_X9dmWPA-dw" type="video/ogg">
                                    Your browser does not support HTML5 video.
                                </video>
                                <p class="text_color">
                                    How to register a new member?
                                </p>
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