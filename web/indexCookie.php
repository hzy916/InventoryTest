<?php
    require_once('inc/config.php');

    // Check if $_SESSION or $_COOKIE already set
    if( isset($_SESSION['id']) ){
        header('Location: dashboard.php');
        exit;
    }else if( isset($_COOKIE['rememberme'] )){
    
        // Decrypt cookie variable value
        $userid = my_decrypt($_COOKIE['rememberme'], $key);
        
        $sql_query = "select count(*) as cntUser,email from tbl_users where email='".$userid."'";

        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];
        // $_SESSION = $count;

        if( $count > 0 ){
            $_SESSION['id'] = $userid; 
            header('Location: dashboard.php');
            exit;
        }
    }
    
    // Encrypt cookie
    function my_encrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }
     // Decrypt cookie
    function my_decrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
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

        $count = $row['cntUser'];
        if($count > 0){
            $userid = $row['id'];
            if( isset($_POST['rememberme']) ){
                // Set cookie variables
                $days = 20;
                $value = my_encrypt($userid, $key);
                setcookie ("rememberme",$value,time()+ ($days * 24 * 60 * 60 * 1000));
            }
                $_SESSION['id'] = $userid; 
                header('Location: dashboard.php');
                // echo "ok";
                exit;
            }else{
                echo "Invalid username and password";
            }
        }
    }

    //log out process
    if(isset($_GET['logout']) && $_GET['logout'] == true)
    {
        session_destroy();
        header("location:index.php");
        exit;

    // Remove cookie variables
        $days = 30;
        setcookie ("rememberme","", time() - ($days * 24 * 60 * 60 * 1000));
   
    }
    if(isset($_GET['lmsg']) && $_GET['lmsg'] == true)
    {
        $errorMsg = "Login required to access dashboard";
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