<?php 

	switch($_SERVER["SERVER_NAME"]){
			
	///////PawTrails Test system FOR Shreya
		case 'blabla2.pawtrails.com':
			$designpath = "/blabla";
			$logopath = "/t.blabla/blabla/uploads";

			define("HOST","blabla");
			define("DB_USER","blabla");
			define("DB_PASS","blabla");
			define("DB_NAME","blabla");
	
		break;
///////PawTrails Test system LOCAL
		case 'blabla1.pawtrails.src':
			$designpath = "/blabla";
			$logopath = "/t.blabla/blabla/uploads";

			define("HOST","blabla");
			define("DB_USER","blabla");
			define("DB_PASS","blabla");
			define("DB_NAME","blabla");
	
		break;

		default:
			$designpath = "/blabla";
			$logopath = "/t.blabla/blabla/uploads";

			define("HOST","blabla");
			define("DB_USER","blabla");
			define("DB_PASS","blabla");
			define("DB_NAME","blabla");
	
		break;
	}

  	session_start();

	$conn = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);
	
	if(!$conn)
	{
		die(mysqli_error());
	}
	
	function getUserAccessRoleByID($id)
	{
		global $conn;
		// $query = "select user_role from tbl_user_role where  id = '$id' ";
		
		$query = "SELECT user_role FROM tbl_user_role WHERE id = {$id}";
	
		$rs = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($rs);
		
		return $row['user_role'];
	}

		
	function getUserName($id)
	{
		global $conn;

		$query = "SELECT user_name FROM tbl_users WHERE id = {$id}";
	
		$rs = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($rs);
		
		return $row['user_name'];
	}


	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);
?>