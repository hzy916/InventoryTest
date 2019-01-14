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
        font-size:20px;
    }

    .container{
        text-align: center;
    }
    .backBtn{
		width: 290px;
		height: 32px;
		border-radius: 2px;
		box-shadow: inset 0 -1px 0 0 #e5e5e5;
		background-color: #f2f2f2;
        text-transform: uppercase;
        border:none;
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
                <img class="emptyItemIMG" src="/assets/img/successrequest.png" src="Empty in your Request">
                                           
                <h3 class="successText">Your Shipment Request has been submitted successfully.</h3>
                <a href="ship.php" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> Make Another Shipment Request</a>
                <br>
                <a href="/dashboard.php" class="backBtn btn  mb-3">Back to Dashboard</a>
            </div>               
    </div>



<?php require_once('../layouts/footer.php');
exit;

?>	

