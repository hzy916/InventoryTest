<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		

	require 'inc/config.php';
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
     //remind user message
     $msg = "";

?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
        
      </ol>

      <hr>
      <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>
   
   <div class="card mb-5"> 
      <div class="card-header">    
           <!--add poster or fylers form-->
           <form action="create_poster_flyer.php" method="post">
            <h4>Add an Poster or Flyer</h4>
                <table cellspacing="0" cellpadding="10">
                    <tr>
                        <th>Item Name</th>
                        <td><input type="text" name="itemname" placeholder="Item Name" required/></td>
                    </tr>     
            
                    <tr>
                        <th>Quantity</th>
                        <td><input type="text" name="amount" placeholder="Amount" required /></td>
                    </tr>
                    <tr>
                        <td><button type="submit" class="btn btn-success">Save</button></td>
                        <td><a href="dashboard.php"><button type="button" class="btn btn-danger">Back</button></a></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

	<!-- DataTables Example -->
	<div class="card mb-5">

		<div class="card-header">    
          <!--add PawTrails form-->
            <form method="post">
             <h4>Add an product</h4>
                <table cellspacing="0" cellpadding="10">
                    <tr>
                        <th>Item Name</th>
                        <td><input type="text" name="itemname" placeholder="Item Name" required/></td>
                    </tr>     
                
                    <tr>
                        <th>Color</th>
                        <td>
                            <select name="color" id="color" class="form-control" required>
                                    <option value="" selected disabled hidden>Choose here</option>
                                    <option value="red">Red</option>
                                    <option value="black">Black</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Size</th>
                        <td>
                            <select name="size" id="size" class="form-control" required>
                                    <option value="" selected disabled hidden>Choose here</option>
                                    <option value="small">Small</option>
                                    <option value="medium">Medium</option>
                                    <option value="large">Large</option>
                            </select>
                        </td>
                        
                    </tr>

                    <tr>
                        <th>Quantity</th>
                        <td><input type="text" name="amount" placeholder="Amount" required /></td>
                    </tr>
                    <tr>
                        <td><button type="submit" class="btn btn-success">Save</button></td>
                        <td><a href="dashboard.php"><button type="button" class="btn btn-danger">Back</button></a></td>
                    </tr>
                </table>
            </form>
        </div>
 
    </div>

    <!-- /.container-fluid-->

<?php
    if($_POST) {
        $itemname = $_POST['itemname'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $amount = $_POST['amount'];
     
        if (isset($amount) && ctype_digit($amount))
        {
        // the get input contains a positive number and is safe
            $sql = "INSERT INTO pawtrails (itemname, color, size, amount) VALUES ('$itemname', '$color', '$size', '$amount')";
            if($conn->query($sql) === TRUE) {
                // $msg = "New Product Successfully Created";
                echo "<script>
                alert('New Product Successfully Created.');
                window.location.href='./inventory.php';
                </script>";
            } else {
                // $msg = "Updating failed.";
                echo "Error " . $sql . ' ' . $conn->connect_error;
            }
            $conn->close();
        } else {
            echo "<script>
            alert('Number should be positive integers.');
            window.location.href='./create.php';
            </script>";
        }
    }
?>

<?php require_once('layouts/footer.php'); ?>	