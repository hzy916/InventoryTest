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
  
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/sb-admin.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="bg-light">
    <!-- Just an image -->
  
    <a class="navbar-brand ml-5 mt-5" href="http://www.attitudetech.ie">
      <img src="assets/img/com_logo.png" width="180" height="47" alt="">
    </a>
  


  <div class="container">
    <h1 class="Hey-Welcome mx-auto mt-5">HEY, WELCOME!</h1>
    	<?php 
			if(isset($errorMsg))
			{
				echo '<div class="alert alert-danger">';
				echo $errorMsg;
				echo '</div>';
				unset($errorMsg);
			}
    ?>
    
    <div class="card card-login mx-auto mt-5 customCard">
      <div class="card-header">PLEASE LOG IN</div>
      <div class="card-body">
	
        <form action="<?php echo $_SERVER['PHP_SELF']?>" class="LoginForm" method="post">
          <label for="exampleInputEmail1">Username (Email)</label>
          <div class="form-group inner-addon left-addon redNote">
                    <!--icon -->
            <img class="glyphicon" src="assets/img/usernameicon.svg">
            <input class="form-control requiredRed" id="exampleInputEmail1" name="email" type="email" placeholder="Enter email" required>
          </div>
         
          <label for="exampleInputPassword1">Password</label>
          <div class="form-group inner-addon left-addon redNote">
            <img class="glyphicon" src="assets/img/passwordicon.svg">
            <input class="form-control requiredRed" id="exampleInputPassword1" name="password" type="password" placeholder="Password" required>
          </div>

        <!--Switch Button in bootstrap -->
        <!-- <div class="toggle-group">
            <label for="on-off-switch">
              Remember Me <span class="aural">Show:</span> 
            </label>

            <input type="checkbox invisible" name="on-off-switch" id="on-off-switch" checked="" tabindex="1">
          
            <div class="onoffswitch pull-right" aria-hidden="true">
                <div class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </div>
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

    <footer class="footer">
        <div class="container">
              <div class="row">
                <div class="col-sm-6">
                  <div class="copyright-text">
                    <p class="footerleft">Staff Portal V.2.0 |  Copyright © 2018 Attitude Technologies Ltd.  All rights reserved.  </p>
                  </div>
                </div> <!-- End Col -->
                <div class="col-sm-6">							
                  <ul id="customlinklist" class="pull-right">
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
