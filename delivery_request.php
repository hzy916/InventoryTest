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
?>

<style>
.hidebutton{
	display: none!important;
}

</style>


        <?php
            // $sql=mysql_query("SELECT id,itemname FROM pawtrails");
            // if(mysql_num_rows($sql)){
            // $select= '<select name="select">';
            //     while($rs=mysql_fetch_array($sql)){
            //         $select.='<option value="'.$rs['id'].'">'.$rs['itemname'].'</option>';
            //     }
            // }
            // $select.='</select>';
            // echo $select;
        ?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Delivery Requests</li>
            </ol>
            <h1>Delivery Requests</h1>
            <hr>
            <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>
            <ul>
                <li><strong>John Doe</strong> has <strong>Administrator</strong> rights so all the left bar items are visible to him</li>	
            </ul>	

        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-form"></i>
                Delivery Requests Form
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <div class="col">
                            <label for="deliveryProduct">Product</label>
                          <!--   <input type="text" class="form-control" id="deliveryProduct" aria-describedby="emailHelp" placeholder="Enter Product"> -->
                          <br>
                            <select name="sproduct" id="sproduct" class="sproduct" class="selectpicker">
                                <?php 
                                $sql = mysqli_query($conn, "SELECT id, itemname FROM pawtrails");
                                while ($row = $sql->fetch_assoc()){
                                echo "<option value=\"owner1\">" . $row['itemname'] . "</option>";
                                }
                                ?>
                            </select>
                            
                        </div>

                        <div class="col">
                            <label for="applicantName">Delivery Date</label>
                            <input type="date" class="form-control" id="deliverydate" placeholder="Enter date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="deliverynumber">Number of Products</label>
                            <input type="number" class="form-control" id="deliverynumber" placeholder="number">
                        </div>
                        <div class="col">
                            <label for="receivercompany">Receiver's Company</label>
                            <input type="text" class="form-control" id="receivercompany" placeholder="receiver company">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="phonenumber">Phone Number</label>
                            <input type="text" class="form-control" id="phonenumber" placeholder="Receiver's phone number">
                        </div>
                        <div class="col">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                    </div>
     
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                        </div>
                        <div class="form-group col-md-2">
                        <label for="inputZip">Postcode</label>
                        <input type="text" class="form-control" id="inputZip">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            I confirm all the information above are correct.
                        </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

    
        </div>
    </div>
    <!-- /.container-fluid-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php  

if($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 3  ) {
	echo('<script>$("#createBtn").addClass("hidebutton");
	$(".OperationColumn").addClass("hidebutton");
	</script>' );
}

?>
<?php require_once('layouts/footer.php'); ?>	