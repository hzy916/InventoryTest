 <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="dashboard.php"><img src="/assets/img/logo-white.png" style="width: 218px; height: 56px; object-fit: cover;"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav " id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="/dashboard.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="/inventory/inventory.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text">Inventory</span>
          </a>
        </li>

      <li id="makeRequest" class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#makerequest">
          <i class="fa fa-fw fa fa-copy"></i>
            <span class="nav-link-text">Make Requests</span>
          </a>
          <ul class="sidenav-second-level collapse" id="makerequest">
            <li>
              <a href="/DeliveryRequests/delivery_request.php">Ask Delivery Requests</a>
            </li>
            <li>
              <a href="/DesignRequests/customize_item_request.php">Ask Design Requests</a>
            </li>
          </ul> 
        </li>


        <li class="nav-item" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#collapseComponents">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Request Lists</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
          <li id="deliveryR_table">
              <a href="/DeliveryRequests/delivery_table.php">Delivery Request List</a>
            </li>
            <li>
              <a href="/DesignRequests/custom_request_table.php">Design Request List</a>
            </li>
          </ul> 
        </li>

   

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
           <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" data-target="#archivedRequest">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Archived Requests</span>
          </a>
            <ul class="sidenav-second-level collapse" id="archivedRequest">
              <li id="deliveryR">
                <a href="/DeliveryRequests/archived_request.php">Delivery Requests</a>
              </li>
              <li>
                <a href="/DesignRequests/archived_custom_request.php">Design Requests</a>
              </li>
            </ul> 
        </li>
  
	

      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link" href="/change_password.php">
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
          <a class="nav-link" href="/index.php?logout=true">
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
  .hidebutton{
    display:none;
  }
  </style>

    <?php 
  //hide make request nav link to designers
  if($_SESSION['user_role_id'] == 4) {
    echo('<script>$("#makeRequest").addClass("hidebutton");
    $("#deliveryR").addClass("hidebutton");
    $("#deliveryR_table").addClass("hidebutton");
    </script>' );
  }

  ?>