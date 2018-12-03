
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

</style>

<div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.attitudetech.ie" class="simple-text">
                        <img src="/assets/img/logo-white.png" alt="" style="width:150px; height:auto;">
                    </a>
                    
                    <div class="item">
                        <img class="EmployeeImg" src="/assets/img/new_logo.png" alt="">
                        <p class="caption"><?php echo getUserName($_SESSION['id']); ?></p>
                    </div>

                </div>
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="./delivery_table.php">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Shipment Requests</p>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./user.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./table.html">
                            <i class="nc-icon nc-notes"></i>
                            <p>Table List</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./typography.html">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>Typography</p>
                        </a>
                    </li>
                    
                    <hr>

                    <li>
                        <a class="nav-link" href="./icons.html">
                            <i class="nc-icon nc-atom"></i>
                            <p>Icons</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./maps.html">
                            <i class="nc-icon nc-pin-3"></i>
                            <p>Maps</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./notifications.html">
                            <i class="nc-icon nc-bell-55"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./notifications.html">
                            <i class="nc-icon nc-bell-55"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
             
                </ul>
            </div>
        </div>
