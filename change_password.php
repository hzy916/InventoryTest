<?php 

	require 'inc/config.php';
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	

	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php');   
    
    $passwordErr = '';

    $user_id = $_SESSION['id'];
    //change password
    if($_POST) {
         //check if two password input isn't empty
        if(isset($_POST['newpassword1']) && isset($_POST['newpassword2'])) {
           
            //check password numbers to be 6 above
            if (strlen($_POST["newpassword1"]) <'6') {
                $passwordErr = "Your Password Must Contain At Least 6 Characters! Change password failed.";
                echo "<script>
                alert('Your Password Must Contain At Least 6 Characters! Change password failed.');
                window.location.href='./change_password.php';
                </script>";
            } else {
                $password1 = $_POST['newpassword1'];
                //encrypted the password;
                $md5Password1 = md5($password1);
            
                $password2 = $_POST['newpassword2'];
                 //encrypted the password;
                $md5Password2 = md5($password2);
    
                if ($md5Password1 != $md5Password2){     
                    
                    $passwordErr = 'your passwords do not match';
                    echo "<script>
                    alert('your passwords do not match, please enter the same one.');
                    window.location.href='./change_password.php';
                    </script>";
                 
                }else {
                    $sql = "UPDATE tbl_users SET password = '$md5Password1' WHERE id = {$user_id}";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>
                        alert('You changed your password successfully.');
                        window.location.href='./index.php';
                        </script>";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    } 
                }
            }  
        }
    }

    //read from database and get current password and username
   
        $sql = "SELECT * FROM tbl_users WHERE id = {$user_id}";
        $result = $conn->query($sql);
        
        $data = $result->fetch_assoc();
        
  
  
?>


  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Change Password</li>
      </ol>
     
      <p><?php echo getUserName($_SESSION['id']); ?> are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>

  
	<!-- DataTables Example -->
	<div class="card mb-3">
		<div class="card-header">
        <h2>Change Password</h2>
        
        <ul>
            <li>Password needs to be at least 6 numbers above</li>
        </ul>

        <form method="post">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <th>User ID</th>
                    <td><?php echo $data['id'] ?> </td>
                </tr>
                <tr>
                    <th>User Role</th>
                    <td><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></td>
                </tr>     
                <tr>
                    <th>User Name</th>
                    <td><?php echo $data['user_name'] ?></td>
                </tr>

                 <tr>
                    <th>Email</th>
                    <td><?php echo $data['email'] ?></td>
                </tr>

                <tr>
                    <th>New Password</th>
                    <td><input type="password" name="newpassword1" placeholder="password" value="" required/></td>
                </tr>
                <tr>
                    <th>Confirm New Password</th>
                    <td><input type="password" name="newpassword2" placeholder="confirm password" value="" required/></td>
                </tr>
          
                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['id']?>" />
                    <td><a href="dashboard.php"><button type="button" class="btn btn-info">Back</button></a></td>
                    <td><button type="submit" class="btn btn-success">Save Changes</button></td>
                </tr>

      

            </table>
        </form>
          </div>
    </div>
    <!-- /.container-fluid-->


<?php 
require_once('layouts/footer.php'); 
   
?>	