
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class=" container-fluid  ">
                 
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <!-- <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <span class="d-lg-block">Welcome, <?php echo getUserName($_SESSION['id']); ?>  are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></span>
                                </a>
                            </li>
                        </ul> -->
                        <ul class="navbar-nav ml-auto">
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Account</span>
                                </a>
                            </li> -->
                     
                            <li class="nav-item">
                                <a class="nav-link" href="/index.php?logout=true">
                                    <!-- <span class="no-icon">Log out</span>  -->
                                     <i class="fa fa-fw fa-sign-out"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
          
            </nav>
            <!-- End Navbar -->
       