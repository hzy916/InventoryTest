<?php
  	require_once('../inc/config.php');
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
        exit;
        $requestUserID = $_SESSION['id'];
	}

	require_once('../layouts/header.php'); 
	require_once('../layouts/side_bar.php'); 
  	require_once('../layouts/nav.php'); 

?>
  <link href="/assets/css/shipment.css" rel="stylesheet" />

<style>
    .successText{   
        color: #5da214;
    }

    .container{
        text-align: center;
    }
</style>

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../dashboard.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">New Shipment Request</li>
            </ol>
          
    
        <!-- MultiStep Form -->
            <div class="container">
                <img class="emptyItemIMG" src="https://cdn.shopify.com/s/files/1/2590/2182/files/Christmas2018-PawTrailsmin.png?8270276245400105272" src="Empty in your Request">
                                           
                <h3 class="successText">Your Shipment Request has been submitted successfully.</h3>
                <a href="ship2.php" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> Make Another Shipment Request</a>
                <br>
                <a href="/dashboard.php" class="cancel btn  mb-3">Back to Dashboard</a>
            </div>               
      
    </div>
</div>



<?php require_once('../layouts/footer.php'); ?>	

