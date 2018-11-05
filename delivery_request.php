<?php
	session_start();

	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
        exit;
        $requestUserID = $_SESSION['id'];
	}

    $sql_four = '';

    require_once('inc/config.php');
	require_once('layouts/header.php');
    require_once('layouts/left_sidebar.php');
    
    $msg = "";

    $myPlist='';

    if($_POST) {
    //     if($_POST['makeaction']=='product')
    //         {
    //         // $myPlist=$_POST['myPlist'].'@'.$_POST['sel_product'].'-'.$_POST['deliverynumber'];
    //   list($pId,$pName)=explode('-', $_POST['sel_product']);

    //         $_SESSION['delivery'][] = [
    //             'product_id' => $pId,
    //             'productname' => $pName,
    //             'deliverynumber' => $_POST['deliverynumber']
                
    //         ];
           
    //         echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
    
    //        }else{
    //             include ('submit_address.php');
    //         }

        switch($_POST['makeaction']) {
            case 'product': 
                list($pId,$pName)=explode('-', $_POST['sel_product']);
                $_SESSION['delivery'][] = [
                    'product_id' => $pId,
                    'productname' => $pName,
                    'deliverynumber' => $_POST['deliverynumber'] 
                ];
            break;

            case 'productDelete':
                unset($_SESSION['delivery'][$_POST['prod2del']]);
            break;

            case 'address':
              include ('submit_address.php');
            break;
        }
    }
 
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
                <li><strong>Sales</strong> and <strong>Marketing</strong> can make delivery request by submitting the form. </li>
            </ul>

        <!-- DataTables Example -->
        <div class="card mb-3" id="deliveryForm">
            <div class="card-header">
                <i class="fas fa-form"></i>
                Delivery Requests Form
            </div>
            <div class="card-body">
                <h4>Choose Product</h4>
                <form method="POST">

                <input type="hidden"  name="makeaction" value="product">
         
                    <div class="form-group row">
                        <div class="col">
                            <label for="deliveryProduct">Product</label>
                          <br>
                            <select name="sel_product" id="sel_product" class="form-control" required>
                                <?php
                                    $sql = mysqli_query($conn, "SELECT id, itemname FROM pawtrails");
                                    while ($row = $sql->fetch_assoc()){
                                        echo "<option value='".$row[id]." - ".$row['itemname']."'>" . $row['itemname'] . "</option>";
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
                            <label for="deliverynumber">Number of Products</label>
                            <input type="number" class="form-control" name="deliverynumber" id="deliverynumber" placeholder="number"  min="1" required>
														
               
                        </div>
                    </div>
                    <input type="submit" name="AddProduct" class="btn btn-info">
                </form>

                <form id="productDelete" method="POST">

                    <input type="hidden"  name="makeaction" value="productDelete">
                    <input id="prod2del" type="hidden"  name="prod2del" value="">

                </form>

                <br>
                <h4>Request Item List</h4>
                <p><?php echo $msg ?></p>
                <div class="table-responsive">
                    <table class="table table-bordered" id="requestProductTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              
                                <th>item id</th>
                                <th>item Name</th>
                                <!-- <th>color</th>
                                <th>size</th> -->
                                <th>amount</th>
                                <th>Operation</th>
                                <!-- <th class="OperationColumn">operation</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php    
                            if(!empty($_SESSION['delivery'])){
                                
                                foreach($_SESSION['delivery'] as $i=> $k) {
                                    echo "<tr>
                                        <td>".$k['product_id']."</td>
                                        <td>".$k['productname']."</td>
                                        <td>".$k['deliverynumber']."</td>
                                        <td class='OperationColumn'>
                                            <button type='button' class='btn btn-danger' onclick='JavaScript:deleteThisProduct(".$i.");'>Remove</button>
                                        </td>
                                        </tr>";
                                        $i++;
                                    }  
                            }
                        ?>
                </tbody>
            </table>
        </div>


                <h4>Receiver's Details</h4>

                <!-- <button class="btn btn-success" onclick="showOld()">Choose From Old Contacts</button>
                <button class="btn btn-warning" onclick="showNew()">Fill New Address</button>
                 -->
                <!-- <div id="oldReceiver">
                    <label for="deliveryProduct">Saved Company Contacts</label>
                    <br>
                    <select name="sel_receiver" id="sel_receiver" class="form-control" required>
                        <?php
                            // $sql = mysqli_query($conn, "SELECT receiver_id, company_name FROM Receiver WHERE company_name IS NOT NULL AND company_name != ''");
                            // while ($row = $sql->fetch_assoc()){
                            // echo "<option value='$row[receiver_id]'>" . $row['company_name'] . "</option>";
                            // }
                        ?>
                    </select>
                </div>
                
                <div>Show Old address</div>
 -->
                <form action="delivery_request.php" method="POST">


                <input type="hidden"  name="makeaction" value="address">
                <!-- <input type="text" name="myPlist" value="<?php echo $myPlist; ?>">
                 -->
                    <div class="form-group row">
                        <div class="col">
                            <label for="applicantName">Shipping Date</label>
                            <input id="date" type="date" class="form-control" name="deliverydate" placeholder="Enter date" required>
                        </div>
                    </div>

                            
                    <div class="form-group row">
                        <div class="col">
                            <label for="receivercompany">Receiver's Company</label>
                            <input type="text" class="form-control" name="receivercompany" placeholder="receiver company" onchange="checkDate()">
                        </div>
                        <div class="col">
                            <label for="phonenumber">Phone Number</label>
                            <input type="text" class="form-control" name="phonenumber" placeholder="#####" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="firstname">First name</label>
                            <input type="text" class="form-control" name="firstname" placeholder="#####" required>
                        </div>
                        <div class="col">
                            <label for="lastname">Last name</label>
                            <input type="text" class="form-control" name="lastname" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                    
                        <div class="form-group col-md-4">
                            <label for="inputAddress">Address1</label>
                            <input type="text" class="form-control" name="inputAddress1" placeholder="1234 Main St" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputAddress">Address2</label>
                            <input type="text" class="form-control" name="inputAddress2" placeholder="1234 Main St" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAddress">Address3</label>
                            <input type="text" class="form-control" name="inputAddress3" placeholder="1234 Main St" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputCity">City</label>
                            <input type="text" class="form-control" name="inputCity" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputCountry">Country</label>
                            <input type="text" class="form-control" name="inputCountry" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputPostcode">Postcode</label>
                            <input type="text" class="form-control" name="inputPostcode" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="checkbox" id="gridCheck" required>
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
        //check ship date to be at least one day after today
        function isFutureDate(idate){
            var today = new Date().getTime(),
                idate = idate.split("/");

            idate = new Date(idate[2], idate[1] - 1, idate[0]).getTime();
            return (today - idate) < 0;
        }

        //hide/show the contact address div
        function toggleDiv(){
            var x = document.getElementById("newReceiver");
            var y = document.getElementById("oldReceiver");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        }
        
        function showOld(){
            var y = document.getElementById("oldReceiver");
            if (y.style.display === "block") {
                y.style.display = "none";
                x.style.display = "block";
            } else {
                y.style.display = "block";
                x.style.display = "none";
            }
        }

        function showNew(){
            var x = document.getElementById("newReceiver");
            if (x.style.display === "block") {
                x.style.display = "none";
                y.style.display = "block";
            } else {
                x.style.display = "block";
                y.style.display = "none";
            }
        }

        function deleteThisProduct(idP){
            $("#prod2del").val(idP);
            $("#productDelete").submit();
        }

	//show color and size option only when user select PawTrails all in one product
			$(document).ready(function(){
                    $("#sel_product").change(function(){
                        var sel_item=$(this).val();
						    var myData = {};
                            myData.itemname = sel_item;
                            alert( myData.itemname );

							if (sel_item == "fed"){
								$("#sizeOption").removeClass("hidedisplay");
								$("#colorOption").removeClass("hidedisplay");
							}else {
								$("#sizeOption").addClass("hidedisplay");
								$("#colorOption").addClass("hidedisplay");
							}
					// });
                    
                    //	send user's select to MYSQL commands to get the stock number of the product selected
                        $.ajax({
                            url: 'getStockNumber.php',
                            type: 'post',
                            data: myData,
                            dataType: 'json',
                            
                            success:function(response){
                           
                                    // var len = response.length;
                                    // // var amount = response[i]['amount'];
                                    //     $("#sel_number").empty();
                                    //     for( var i = 0; i < len; i++){
                                    //         var id = response[i]['id'];
                                    //         var amount = response[i]['amount'];
                                    //         $("#sel_number").append("<option value='"+id+"'>"+ amount +"</option>");
                                    //     }
                            }
                        });

					});

			    });
	</script>

<?php
    
      // IF they are not admin, hide the make delivery request form
      if($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 4 ) {
        echo('<script>$("#deliveryForm").addClass("hidedisplay");
        </script>' );
    }

?>

<?php
  $conn->close();
?>



<?php require_once('layouts/footer.php'); ?>

