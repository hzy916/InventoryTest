<?php
	require_once('inc/config.php');

    // Check if $_SESSION or $_COOKIE already set
    if( isset($_SESSION['userid']) ){
        header('Location: dashboard.php');
        exit;
    }else if( isset($_COOKIE['rememberme'] )){
    
        // Decrypt cookie variable value
        $userid = decryptCookie($_COOKIE['rememberme']);
        
        $sql_query = "select count(*) as cntUser,id from users where id='".$userid."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if( $count > 0 ){
        $_SESSION['userid'] = $userid; 
        header('Location: home.php');
        exit;
        }
    }

    // Encrypt cookie
    function encryptCookie( $value ) {
        $key = 'youkey';
        $newvalue = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $key ), $value, MCRYPT_MODE_CBC, md5( md5( $key ) ) ) );
        return( $newvalue );
    }

    // Decrypt cookie
    function decryptCookie( $value ) {
        $key = 'youkey';
        $newvalue = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $key ), base64_decode( $value ), MCRYPT_MODE_CBC, md5( md5( $key ) ) ), "\0");
        return( $newvalue );
    }

    // On submit
    if(isset($_POST['but_submit'])){
  
        $email 		= trim($_POST['txt_uname']);
		$password 	= trim($_POST['txt_pwd']);
		
		$md5Password = md5($password);
    
    if ($email != "" && $md5Password != ""){

        $sql_query = "select count(*) as cntUser,id from tbl_users where email='".$email."' and password='".$md5Password."'";

        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_array($result);

        // $sql = "select * from tbl_users where email = '".$uname."' and password = '".$password."'";
		// $rs = mysqli_query($conn,$sql);
		// $getNumRows = mysqli_num_rows($rs);

        $count = $row['cntUser'];
        if($count > 0){
            $userid = $row['id'];
            if( isset($_POST['rememberme']) ){

                // Set cookie variables
                $days = 20;
                $value = encryptCookie($userid);
                setcookie ("rememberme",$value,time()+ ($days * 24 * 60 * 60 * 1000));
            }
        
                $_SESSION['userid'] = $userid; 
                header('Location: dashboard.php');
                exit;
            }else{
                echo "Invalid username and password";
            }
        }
    }
?> 
<html>  
 <head>  
  <title>Webslesson - Tutorial</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <style>  
  body  
  {  
   margin:0;  
   padding:0;  
   background-color:#f1f1f1;  
  }  
        .box  
        {  
   width:700px;  
   padding:20px;  
   background-color:#fff;  
  }  
  </style>  
 </head>  
 <body>  
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Login</h1>
                <div>
                <input type="email" class="textbox" name="txt_uname" placeholder="Username" />
                </div>

                <div>
                <input type="password" class="textbox" name="txt_pwd" placeholder="Password"/>
                </div>

                <div>
                <input type="checkbox" name="rememberme" value="1" />&nbsp;Remember Me
                </div>

                <div>
                <input type="submit" value="Submit" name="but_submit" />
                </div>
            </div>
        </form>
    </div>
 </body>  
</html>