 <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="dashboard.php"><img src="./assets/img/logo_white.png" style="width: 218px; height: 56px; object-fit: cover;"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav " id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="dashboard.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="inventory.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text">Inventory</span>
          </a>
        </li>

       <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Delivery List">
          <a class="nav-link" href="delivery_table.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text">Delivery List</span>
          </a>
        </li>
		<?php 
		//only visible to admin and editor
		if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3){?>
		
			 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
			  <a class="nav-link" href="delivery_request.php">
				<i class="fa fa-fw fa fa-copy"></i>
				<span class="nav-link-text">Delivery Requests</span>
			  </a>
			</li>
			
			<!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
			  <a class="nav-link" href="#">
				<i class="fa fa-fw fa-circle-o-notch"></i>
				<span class="nav-link-text">Categories</span>
			  </a>
			</li> -->
		
		<?php }?>
		
		<?php 
		//only visible to admin 
		if(($_SESSION['user_role_id'] == 1)){?>
		
        <!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Archived Requests</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="#">Themes</a>
            </li>
            <li>
              <a href="#">Archived Requests</a>
            </li>
          </ul> 
        </li> -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
           <a class="nav-link" href="archived_table.php">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Archived Requests</span>
          </a>
        </li>
  
		<?php } ?>

      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link" href="change_password.php">
          <i class="fa fa-fw fa fa-gear"></i>
          <span class="nav-link-text">Change Password</span>
        </a>
      </li>

    </ul>
     
	 
	 
      <ul class="navbar-nav ml-auto">
        
        <li class="nav-item">
          <a class="nav-link">
          <p class="welcomeMSG"> Hello, <?php echo getUserName($_SESSION['id']); ?></p>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="index.php?logout=true">
            <i class="fa fa-fw fa-sign-out"></i>Logout
		      </a>
        </li>
      </ul>
    </div>
  </nav>

  <style>
  .welcomeMSG{
    color:#ffffff;

  }
  </style>