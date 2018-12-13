<?php
	session_start(); // starting a session
	include('inc/config.php'); // Database configuration file
	// Check if $_SESSION or $_COOKIE already set
	if( isset($_SESSION['userid']) ){
		header('Location: dashboard.php');
		exit;
	}else if( isset($_COOKIE['rememberme'] )){
		
		// Decrypt cookie variable value
		$userid = decryptCookie($_COOKIE['rememberme']);
		
		$sql_query = "select count(*) as cntUser,id from tbl_users where id='".$userid."'";
		$result = mysqli_query($conn,$sql_query);
		$row = mysqli_fetch_array($result);
	
		$count = $row['cntUser'];
	
		if( $count > 0 ){
		$_SESSION['userid'] = $userid; 
		header('Location: dashboard.php');
		exit;
		}
	}
	
	// Encrypt cookie
	// function encryptCookie( $value ) {
	// 	$key = 'youkey';
	// 	$newvalue = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $key ), $value, MCRYPT_MODE_CBC, md5( md5( $key ) ) ) );
	// 	return( $newvalue );
	// }
	
	// // Decrypt cookie
	// function decryptCookie( $value ) {
	// 	$key = 'youkey';
	// 	$newvalue = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $key ), base64_decode( $value ), MCRYPT_MODE_CBC, md5( md5( $key ) ) ), "\0");
	// 	return( $newvalue );
	// }
	
	// On submit
// 	if(isset($_POST['login'])){
// 		$uname = mysqli_real_escape_string($conn,$_POST['email']);
// 		$password = mysqli_real_escape_string($conn,$_POST['password']);
		
// 		if ($uname != "" && $password != ""){
	
// 		$sql_query = "select count(*) as cntUser,id from tbl_users where email='".$uname."' and password='".$password."'";
// 		$result = mysqli_query($conn,$sql_query);
// 		$row = mysqli_fetch_array($result);
	
// 		$count = $row['cntUser'];
	
		// if($count > 0){
		// $userid = $row['id'];
		// if( isset($_POST['rememberme']) ){
		// 	// Set cookie variables
		// 	$days = 30;
		// 	$value = encryptCookie($userid);
		// 	setcookie ("rememberme",$value,time()+ ($days * 24 * 60 * 60 * 1000));
		// 	}
		
		// 	$_SESSION['userid'] = $userid; 
		// 	header('Location: dashboard.php');
		// 	exit;
		// 	}else{
		// 	echo "Invalid username and password";
		// 	}
		// }
	
//    }


   if(isset($_POST['login'])){
	if(!empty($_POST['email']) && !empty($_POST['password']))
	{
		$email 		= trim($_POST['email']);
		$password 	= trim($_POST['password']);
		
		$md5Password = md5($password);
		
		$sql = "select * from tbl_users where email = '".$email."' and password = '".$md5Password."'";
		$rs = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($rs);
		$getNumRows = mysqli_num_rows($rs);
		
		if($getNumRows > 0){	
				$userid = $row['id'];
			if( isset($_POST['rememberme']) ){
				// Set cookie variables
				$days = 30;
				$value = $userid;
				setcookie ("rememberme",$value,time()+ ($days * 24 * 60 * 60 * 1000));
			}else{

				$_SESSION['userid'] = $userid; 
				header('Location: dashboard.php');
				exit;	
			}
			// $getUserRow = mysqli_fetch_assoc($rs);
			// unset($getUserRow['password']);
			
    		// $_SESSION = $getUserRow;
						
			// header('location:dashboard.php');
			// exit;
		}
		else
		{
			$errorMsg = "Username or password incorrect. Please try again.";
		}
  }
}

?>

