<style>
html,
body {
 height: 100%;
 position: relative;
}


#customlinklist{
    text-align:right;
}
/* 
@media (max-width: 768px){
    #customlinklist{
        padding-inline-start: 0px!important;
    }
    #customlinklist{
        text-align:left;
    }
} */

  #customlinklist li a {
      color: #525a65!important;
  }

  .pull-right {
      float: right;
      line-height:50px;
  }
  @media (min-width: 1500px){
    .custom_container_large{
        max-width: 1440px!important;
    }
  }

/***flexbox footer*/
  .flex-grid {
  display: flex;
}
.col_hzy {
  flex: 1;
}

@media (max-width: 400px) {
  .flex-grid {
    display: block;
  }
}
/***remove the space under footer, to put text in the vertical center***/
#customlinklist{
    margin-bottom:0!important;
}
  </style>
    
      </div>
         <footer class="footer">
              <div class="container custom_container_large">
                  <!-- <div class="row">  
                    <div class="column_half col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- <div class="copyright-text"> -->
                         
                        <!-- </div> 
                      </div>
                    <div class="column_half col-lg-6 col-md-6 col-sm-12 col-xs-12">				
                        <ul id="customlinklist">
                          <li><a href="">Privacy Policy |</a></li>						
                          <li><a href="">Terms of Use |</a></li>
                          <li><a href="">PawTrails Website | </a></li>
                          <li><a href="">Help</a></li>
                        </ul>							
                    </div> 
                  </div>  -->
                  <div class="flex-grid">
                    <div class="col_hzy"> <p class="footerleft">Staff Portal V.2.0 |  Copyright © 2018 Attitude Technologies Ltd.  All rights reserved.  </p></div>
                    <div class="col_hzy">    
                          <ul id="customlinklist">
                          <li><a href="">Privacy Policy |</a></li>						
                          <li><a href="">Terms of Use |</a></li>
                          <li><a href="">PawTrails Website | </a></li>
                          <li><a href="">Help</a></li>
                        </ul>	
                    </div>
                </div>
              </div>
          </footer>
 
    </div>
    

 
     
</body>
<!--   Core JS Files   -->

<script src="/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="/assets/js/plugins/bootstrap-switch.js"></script>

 <!-- Chartist Plugin 
<script src="/assets/js/plugins/chartist.min.js"></script> -->

<!--  Notifications Plugin   -->
<!-- <script src="/assets/js/plugins/bootstrap-notify.js"></script> -->
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

</html>

<?php
  if($conn){
    $conn->close();
  }
 
  ?>