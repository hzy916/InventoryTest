
<?php 
	// require_once('../inc/config.php');
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	
?>

<style>
/***Custom color**/
.sidebar:after, body>.navbar-collapse:after {
   background: #525a65!important;
}
    .EmployeeImg{
       width:80px;
       border-radius:50%;
    }

  div.item {
    vertical-align: top;
    display: inline-block;
    text-align: center; 
    width: 120px;
}

.caption {
    display: block;
}

.logo{
    text-align: center;

}

.shipbutton{
    transition: 0.5s;
    background-size: 200% auto;
    color: white;
    border-radius: 2px;
}

.btn-1 {
  background-image: linear-gradient(to left, #01bcd5, #2296f3);
    border: none;
}

.shipbutton:hover {
  background-position: right center; /* change the direction of the change here */
}
.customstyle{
    top:10px!important;
    left: 50px!important;
    position:relative!important;
}

.statusIcon{
    margin-right:5px;
}

</style>

<div class="sidebar" data-image="../assets/img/sidebar-2.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.attitudetech.ie" class="simple-text mb-3">
                        <img src="/assets/img/logo-white.png" alt="" style="width:140px; height:auto;">
                    </a>
                    
                    <div class="item mb-3">
                        <img class="EmployeeImg" src="/assets/img/new_logo.png" alt="">
                        <p class="caption"><?php echo getUserName($_SESSION['id']); ?></p>
                    </div>

                    <a href="/DeliveryRequests/ship2.php" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> New Shipment Request</a>
               </div>

                <ul class="nav">

<!-- ***********Dropdown Menu with sub tab********** -->
                    <li class="dropdown multiSide">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Shipment Requests</p>
                        </a>
                        <ul class="dropdown-menu customstyle">
                            <li>
                            <a class="nav-link" href="/DeliveryRequests/shipment_list.php?mystatus=submitted"><img class="statusIcon" src="/assets/img/submitted.svg"><span class="">Submitted</span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DeliveryRequests/shipment_list.php?mystatus=processing"><img class="statusIcon" src="/assets/img/processing.svg"><span class="">Processing</span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DeliveryRequests/shipment_list.php?mystatus=completed"><img class="statusIcon" src="/assets/img/completed.svg"><span class="">Completed</span></a>
                            </li>
                            <li>
                            <a class="nav-link"   href="/DeliveryRequests/shipment_list.php?mystatus=declined"><img class="statusIcon" src="/assets/img/declined.svg"><span class="">Declined</span></a>
                            </li>
                        </ul>
                    </li>

                    <hr>



                    <li class="dropdown multiSide">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Design Requests</p>
                        </a>
                        <ul class="dropdown-menu customstyle">
                            <li>
                            <a class="nav-link" href="/DeliveryRequests/design_request_table.php?mystatus=submitted"><img class="statusIcon" src="/assets/img/submitted.svg"><span class="">Submitted</span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DeliveryRequests/design_request_table.php?mystatus=designing"><img class="statusIcon" src="/assets/img/processing.svg"><span class="">Processing</span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DeliveryRequests/design_request_table.php?mystatus=completed"><img class="statusIcon" src="/assets/img/completed.svg"><span class="">Completed</span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DeliveryRequests/design_request_table.php?mystatus=declined"><img class="statusIcon" src="/assets/img/declined.svg"><span class="">Declined</span></a>
                            </li>
                        </ul>
                    </li>

                    <hr>

                    <li>
                        <a class="nav-link" href="/DeliveryRequests/design_request_table.php?mystatus=declined">
                            <i class="nc-icon nc-bell-55"></i>
                            <p>Inventory</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
