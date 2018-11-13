<?php 
	// define("HOST","localhost");
	// define("DB_USER","pawtrails");
	// define("DB_PASS","attitudetech2018");
	// define("DB_NAME","Pawtrails_inventory");
	
	//////////////PawTrails Test system FOR Shreya
	// define("HOST","localhost");
	// define("DB_USER","pawtrails");
	// define("DB_PASS","attitudetech2018");
	// define("DB_NAME","Pawtrails_inventory_test");

	define("HOST","localhost");
	define("DB_USER","root");
	define("DB_PASS","root");
	define("DB_NAME","Pawtrails_inventory");
	
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

?>