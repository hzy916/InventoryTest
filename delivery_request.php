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
	.hidedisplay{
		display: none!important;
	}


</style>

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
        <div class="card mb-3" id="deliveryForm">
            <div class="card-header">
                <i class="fas fa-form"></i>
                Delivery Requests Form
            </div>
            <div class="card-body">
                <h4>Choose Product</h4>
                <form action="submit_DeliveryRequest.php">
                    <div class="form-group row">
                        <div class="col">
                            <label for="deliveryProduct">Product</label>
                          <br>
                            <select name="sel_product" id="sel_product" class="form-control" required>
                                <?php
                                    $sql = mysqli_query($conn, "SELECT id, itemname FROM pawtrails");
                                    while ($row = $sql->fetch_assoc()){
                                    echo "<option value='$row[itemname]'>" . $row['itemname'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col hidedisplay" id="colorOption">
                            <label for="deliveryProduct">Color</label>
                          <br>
                            <select name="sel_color" id="sel_color" class="form-control">
                                <?php
                                    // $sql = mysqli_query($conn, "SELECT id, color FROM pawtrails");
                                    // while ($row = $sql->fetch_assoc()){
                                    // echo "<option value=\"id\">" . $row['color'] . "</option>";
                                    // }
                                ?>
																<option value="" selected disabled hidden>Choose here</option>
																<option value="red">Red</option>
																<option value="black">Black</option>
                            </select>
                        </div>


                    </div>

                    <div class="form-group row">
                        <div class="col hidedisplay" id="sizeOption">
                            <label for="deliverynumber">Size</label>
                            <br>
                            <select name="sel_size" id="sel_size" class="form-control">
															<option value="" selected disabled hidden>Choose here</option>
															<option value="small">Small</option>
															<option value="medium">Medium</option>
															<option value="big">Big</option>
                            </select>
                        </div>

                        <div class="col">
                            <!-- <label for="deliverynumber">Number of Products</label>
                            <input type="number" class="form-control" id="deliverynumber" placeholder="number" required>
														 -->
														 <select id="sel_number">
																 <option value="0">- Select -</option>
														 </select>
                        </div>
                    </div>

                </form>

                <h4>Request Details</h4>
                <form action="" method="post">
                    <div class="form-group row">
                        <div class="col">
                            <label for="applicantName">Delivery Date</label>
                            <input type="date" class="form-control" id="deliverydate" placeholder="Enter date" required>
                        </div>

                        <div class="col">
                            <label for="receivercompany">Receiver's Company</label>
                            <input type="text" class="form-control" id="receivercompany" placeholder="receiver company">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="phonenumber">Phone Number</label>
                            <input type="text" class="form-control" id="phonenumber" placeholder="#####" required>
                        </div>
                        <div class="col">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <input type="text" class="form-control" id="inputCity" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputCountry">Country</label>
                            <input type="text" class="form-control" id="inputCountry" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="inputPostcode">Postcode</label>
                            <input type="text" class="form-control" id="inputPostcode" required>
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

	<script type="text/javascript">

	//show color and size option only when user select PawTrails all in one product
			$(document).ready(function(){
					$("#sel_product").change(function(){
                        var sel_item=$(this).val();
							var myData = {};
                            myData.itemname = sel_item;
                            

							if (sel_item == "test"){
								$("#sizeOption").removeClass("hidedisplay");
								$("#colorOption").removeClass("hidedisplay");
							}else {
								$("#sizeOption").addClass("hidedisplay");
								$("#colorOption").addClass("hidedisplay");
							}
                     
                            alert(JSON.stringify(myData));
						//	send user's select to MYSQL commands to get the stock number of the product selected
							$.ajax({
                                

							    url: 'getStockNumber.php',
							    type: 'post',
							    data: myData,
							    dataType: 'json',
                               

							    success:function(response){
									alert(JSON.stringify(response));

										var len = response.length;
											 $("#sel_number").empty();
											 for( var i = 0; i<len; i++){
                                                var id = response[i]['id'];
                                                var amount = response[i]['amount'];

                                                $("#sel_number").append("<option value='"+id+"'>"+amount+"</option>");
										    }
							    	}
							});
					});
			    });

					// $("#sel_color").change(function(){
					// 		var sel_color = $(this).val();
					// });
					//
					// $("#sel_size").change(function(){
					// 		var sel_size = $(this).val();
					// });



	</script>
<?php
    // IF they are not admin, hide the make delivery request form
    if($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 4 ) {
        echo('<script>$("#deliveryForm").addClass("hidedisplay");
        </script>' );
    }
?>



<?php require_once('layouts/footer.php'); ?>
