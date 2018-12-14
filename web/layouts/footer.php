<style>

  /*****footer style*****/

  .footerleft {
      font-family: 'OpenSans';
      font-size: 13px;
      font-weight: normal;
      font-style: normal;
      font-stretch: normal;
      line-height: normal;
      letter-spacing: normal;
      color: #525a65;
      line-height: 60px;
  }

  #customlinklist li {
      display: inline;
      font-family: 'OpenSans';
      font-size: 13px;
      font-weight: normal;
      font-style: normal;
      font-stretch: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
  }

  #customlinklist li a {
      color: #525a65!important;
  }

  .pull-right {
      float: right;
      line-height:50px;
  }
  </style>
  

          
    </div>
<!--     
          <footer class="footer">
          <div class="container">
                <div class="row clearfix">
                  <div class="col-lg-6 col-sm-12 float-left">
                    <div class="copyright-text">
                      <p class="footerleft">Staff Portal V.2.0 |  Copyright © 2018 Attitude Technologies Ltd.  All rights reserved.  </p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12 pull-right">							
                    <ul id="customlinklist">
                      <li><a href="">Privacy Policy |</a></li>						
                      <li><a href="">Terms of Use |</a></li>
                      <li><a href="">PawTrails Website | </a></li>
                      <li><a href="">Help</a></li>
                    </ul>							
                  </div> 

                </div>
            </div>
        </div>
      </footer> -->
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