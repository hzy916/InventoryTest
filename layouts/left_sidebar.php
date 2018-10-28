 <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="dashboard.php"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
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
		<?php 
		//only visible to admin and editor
		if($_SESSION['user_role_id'] != 4){?>
		
			 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
			  <a class="nav-link" href="delivery_request.php">
				<i class="fa fa-fw fa fa-copy"></i>
				<span class="nav-link-text">Delivery Requests</span>
			  </a>
			</li>
			
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
			  <a class="nav-link" href="#">
				<i class="fa fa-fw fa-circle-o-notch"></i>
				<span class="nav-link-text">Categories</span>
			  </a>
			</li>
		
		<?php }?>
		
		<?php 
		//only visible to admin and editor
		if(($_SESSION['user_role_id'] == 1) || $_SESSION['user_role_id'] == 2 ){?>
		
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Appearance</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="#">Themes</a>
            </li>
            <li>
              <a href="#">Menus</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link" data-toggle="collapse" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Components</span>
          </a>
 
        </li>
  
		<?php } ?>
		<?php 
		//only visible to admin
		if($_SESSION['user_role_id'] == 1){?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
      <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseSettings" data-parent="#exampleAccordion">
        <i class="fa fa-fw fa fa-gear"></i>
        <span class="nav-link-text">Settings</span>
      </a>
      <ul class="sidenav-second-level collapse" id="collapseSettings">
        <li>
          <a href="#">Add a user</a>
        </li>
        <li>
          <a href="#">Change Password</a>
        </li>
      </ul>
		</li>
		
		<?php
		}
		?>
        
      </ul>
     
	 
	 
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <a class="nav-link" href="index.php?logout=true">
            <i class="fa fa-fw fa-sign-out"></i>Logout
		  </a>
        </li>
      </ul>
    </div>
  </nav>