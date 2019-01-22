
<?php 
	// require_once('../inc/config.php');
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
        header('location:index.php?lmsg=true');
        // echo "sidebar";
		exit;
    }	
    	
       //get number of Shipment Request in different status
       function getNumberRequest($status, $conn){
        $sql = "SELECT * FROM Request Where Request.RequestStatusID =". $status;

        $result =   $conn->query($sql);
        $data = mysqli_num_rows($result);
    
        return $data;   
    }

     //get number of Design Request in different status
    function getNumberDesignRequest($status, $conn){
        $sql = "SELECT * FROM CustomRequest Where CustomRequest.c_RequestStatusID =". $status;

        $result =   $conn->query($sql);
        $data = mysqli_num_rows($result);
    
        return $data;   
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

/**center user image and name**/
.caption {
    display: block;
}

.logo{
    text-align: center;
}

.caption{
    float:none;
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
  color:#ffffff!important;
}
.customstyle{
    top:10px!important;
    left: 40px!important;
    position:relative!important;
}


/*******Side bar Style**********/
.inventoryIcon{
    margin-right: 15px;
    width: 25px;
}    

.statusIcon{
    margin-right:5px;
}
</style>

<div class="sidebar">
   
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.attitudetech.ie" class="simple-text mb-3">
                        <img src="/assets/img/logo-white.png" alt="" style="width:140px; height:auto;">
                    </a>
                    
                    <div class="item mb-3">
                        <img class="EmployeeImg" src="/assets/img/new_logo.png" alt="">
                        <p class="caption"><?php echo getUserName($_SESSION['id']); ?></p>
                    </div>

                    <a href="/DeliveryRequests/ship.php" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> New Shipment Request</a>
               </div>

                <ul class="nav">
                

                    <li>
                        <a class="nav-link" href="/Dashboard.php">
                            <img class="inventoryIcon" src="/assets/img/inventory.svg">
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <hr style="border-top: 1px solid #6b7077;">
<!-- ***********Dropdown Menu with sub tab********** -->
                    <li class="dropdown multiSide">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Shipment Requests</p>
                        </a>
                        <ul class="dropdown-menu customstyle">
                            <li>
                            <a class="nav-link" href="/DeliveryRequests/shipment_list.php?mystatus=submitted"><img class="statusIcon" src="/assets/img/submitted.svg"><span class="">Submitted</span><span class="numberfloat"><?php echo getNumberRequest(1 , $conn); ?></span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DeliveryRequests/shipment_list.php?mystatus=processing"><img class="statusIcon" src="/assets/img/processing.svg"><span class="">Processing</span><span class="numberfloat"><?php echo getNumberRequest(2, $conn); ?></span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DeliveryRequests/shipment_list.php?mystatus=completed"><img class="statusIcon" src="/assets/img/completed.svg"><span class="">Completed</span><span class="numberfloat"><?php echo getNumberRequest(5, $conn); ?></span></a>
                            </li>
                            <li>
                            <a class="nav-link"   href="/DeliveryRequests/shipment_list.php?mystatus=declined"><img class="statusIcon" src="/assets/img/declined.svg"><span class="">Declined</span>  <span class="numberfloat"><?php echo getNumberRequest(6, $conn); ?></span></a>
                            </li>
                        </ul>
                    </li>

                    <hr style="border-top: 1px solid #6b7077;">

               
                    <!--  -->
                    <li class="dropdown multiSide">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Design Requests</p>
                        </a>
                        <ul class="dropdown-menu customstyle">
                            <li>
                            <a class="nav-link" href="/DesignRequests/design_request_table.php?mystatus=submitted"><img class="statusIcon" src="/assets/img/submitted.svg"><span class="">Submitted</span><span class="numberfloat"><?php echo getNumberDesignRequest( 1, $conn); ?></span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DesignRequests/design_request_table.php?mystatus=approved"><img class="statusIcon" src="/assets/img/processing.svg"><span class="">Approved</span><span class="numberfloat"><?php echo getNumberDesignRequest( 9, $conn); ?></span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DesignRequests/design_request_table.php?mystatus=completed"><img class="statusIcon" src="/assets/img/completed.svg"><span class="">Completed</span><span class="numberfloat"><?php echo getNumberDesignRequest( 5, $conn); ?></span></a>
                            </li>
                            <li>
                            <a class="nav-link"  href="/DesignRequests/design_request_table.php?mystatus=declined"><img class="statusIcon" src="/assets/img/declined.svg"><span class="">Declined</span><span class="numberfloat"><?php echo getNumberDesignRequest( 6, $conn); ?></span></a>
                          
                            </li>
                        </ul>
                    </li>
                  
                    <hr style="border-top: 1px solid #6b7077;">

                    <li>
                        <a class="nav-link" href="/inventory/inventory.php">
                            <img class="inventoryIcon" src="/assets/img/inventory.svg">
                            <p>Inventory</p>
                        </a>
                    </li>
                    <hr style="border-top: 1px solid #6b7077;">

                </ul>
            </div>
        </div>
