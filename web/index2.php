<?php 
require_once('inc/config.php');
if(isset($_POST['login']))
{
	if(!empty($_POST['email']) && !empty($_POST['password']))
	{
		$email 		= trim($_POST['email']);
		$password 	= trim($_POST['password']);
		
		$md5Password = md5($password);
		
		$sql = "select * from tbl_users where email = '".$email."' and password = '".$md5Password."'";
		$rs = mysqli_query($conn,$sql);
		$getNumRows = mysqli_num_rows($rs);
		
		if($getNumRows == 1)
		{
			$getUserRow = mysqli_fetch_assoc($rs);
			unset($getUserRow['password']);
			
      $_SESSION = $getUserRow;
						
			header('location:dashboard.php');
			exit;
		}
		else
		{
			$errorMsg = "Username or password incorrect. Please try again.";
		}
	}
}

if(isset($_GET['logout']) && $_GET['logout'] == true)
{
	session_destroy();
	header("location:index.php");
	exit;
}
if(isset($_GET['lmsg']) && $_GET['lmsg'] == true)
{
	$errorMsg = "Login required to access dashboard";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PawTrails Portal</title>
   <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!-- CSS Files -->
  
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/sb-admin.css" rel="stylesheet">

  <link href="./assets/css/main.css" rel="stylesheet">

</head>
<style>

html,
body {
 height: 100%;
 padding:0;
 margin:0;
 position: relative;
}


.footer_container{
  width:95%;
}
.copyright-text{
  margin-left: 40px;
}
.footerleft, #customlinklist{
  margin-bottom:0px;
}

.wrapperLogin{
    min-height: calc(100% - 160px);
    margin-bottom: 50px;
    /**in order to center the log in form both horizontally and vertically*/
    height: 100%;
    width: 100%;
    display:table;
}
.close_icon{
  margin:0px 10px;
  width:35px;
}

#customlinklist{
  text-align:right;
}
.center_login{
    display: table-cell;
    height: 100%;
    vertical-align: middle;
}
/**to remove the text-align:right when footer column becomes stack*/
@media screen and (max-width: 992px) {
  #customlinklist{
    text-align:left;
  }
}
</style>

<body class="bg-light">
    <!-- Just an image -->
  
 
  
<div class="wrapperLogin">
  <div class="container center_login">
      <a class="navbar-brand ml-5 mt-5" href="http://www.attitudetech.ie">
        <img src="assets/img/com_logo.png" width="180" height="47" alt="">
      </a>
    <h1 class="Hey-Welcome mx-auto mt-5">Hey, Welcome!</h1>
    	<?php 
			if(isset($errorMsg))
			{
				echo '<div class="alert alert-danger"><img class="close_icon" src="./assets/img/close_icon.png" alt="close">';
				echo $errorMsg;
				echo '</div>';
				unset($errorMsg);
			}
    ?>
    
    <div class="card card-login mx-auto mt-5 customCard">
      <div class="card-header login_header">Please log in</div>
      <div class="card-body">
	
        <form action="<?php echo $_SERVER['PHP_SELF']?>" class="LoginForm" method="post">
          <label class="login_label" for="exampleInputEmail1">Username (Email)</label>
          <div class="form-group inner-addon left-addon redNote">
                    <!--icon -->
            <img class="glyphicon" src="assets/img/usernameicon.svg">
            <input class="form-control requiredRed" id="exampleInputEmail1"  value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" name="email" type="email" placeholder="Enter email" required>
          </div>
         
          <label class="login_label" for="exampleInputPassword1">Password</label>
          <div class="form-group inner-addon left-addon redNote">
            <img class="glyphicon" src="assets/img/passwordicon.svg">
            <input class="form-control requiredRed" id="exampleInputPassword1" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" name="password" type="password" placeholder="Password" required>
          </div>

          <!--remember me -->
           <!-- <div class="field-group">
              <div>
                  <input type="checkbox" name="remember" id="remember"
                      <?php if(isset($_COOKIE["member_login"])) { ?> checked
                  <?php } ?> /> 
                  <label for="remember-me">Remember me</label>
              </div>
          </div> -->


       
        <p class="notmember">NOT A MEMBER? <br><a href="#" class="applymember text-center">APPLY FOR MEMBERSHIP NOW</a></p>
        <hr>
          <div class="row">
            <hr>
            <div class="col-sm-12 text-center mt-3 mb-3">
              <button class="btn btn-login uppercase" type="submit" name="login">Login</button>
              <a class="btn btn-close uppercase" href="http://www.pawtrails.com">Close</a>
            </div>
          </div>
        </form>
       
      </div>
    </div>
  </div>
</div>
    <footer class="footer">
        <div class="footer_container">
              <div class="row clearfix">
                <div class="col-lg-6 col-sm-12 col-xs-6 float-left">
                  <div class="copyright-text">
                    <p class="footerleft">Staff Portal V.2.0 |  Copyright © 2018 Attitude Technologies Ltd.  All rights reserved.  </p>
                  </div>
                </div> <!-- End Col -->
                <div class="col-lg-6 col-sm-12 col-xs-6 pull-right">							
                  <ul id="customlinklist">
                    <li><a href="">Privacy Policy |</a></li>						
                    <li><a href="">Terms of Use |</a></li>
                    <li><a href="">PawTrails Website | </a></li>
                    <li><a href="">Help</a></li>
                  </ul>							
                </div> <!-- End Col -->

              </div>
          </div>
      </div>
    </footer>


</body>

</html>

