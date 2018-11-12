
<?php

    require_once('inc/config.php');
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
        exit;
        $requestUserID = $_SESSION['id'];
	}

    $sql_four = '';

  
	require_once('layouts/header.php');
    require_once('layouts/left_sidebar.php');
    
    $msg = "";

    $myPlist='';

  
    if($_POST) {
        $doAction = true;

        switch($_POST['makeaction']) {
            case 'product': 
                list($pId,$pName,$maxAmount)=explode('-', $_POST['sel_product']);
                $dNumber = intval($_POST['deliverynumber']);

                if($dNumber == 0 ){
                    echo '<script> alert("You have to enter a valid number");</script>';
                    $doAction = false;
                }else if($dNumber > $maxAmount){
                    echo '<script> alert("Out of Stock");</script>';
                    $doAction = false;
                } else{
                    $_SESSION['delivery'][] = [
                        'product_id' => $pId,
                        'productname' => $pName,
                        'sel_color' => '/',
                        'sel_size' => '/',
                        'deliverynumber' => $dNumber
                    ];
                }
          
            break;

            case 'productDelete':
                unset($_SESSION['delivery'][$_POST['prod2del']]);
            break;

            case 'pawtrailsSelect':
                $sel_color = $_POST['sel_color'];
                $sel_size = $_POST['sel_size'];

                $sql = "SELECT id FROM pawtrails  WHERE color = '$sel_color' AND size = '$sel_size'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array()) {
                  $sel_id = $row[0]; 
                  $maxQty = $row[1];
                }
                
                $dNumber = intval($_POST['deliverynumber']);

                if($dNumber == 0 ){
                    echo '<script> alert("You have to enter a valid number");</script>';
                    $doAction = false;
                }else if($dNumber > $maxQty){
                    echo '<script> alert("Out of Stock");</script>';
                    $doAction = false;
                } else{
                    $_SESSION['delivery'][] = [
                        'product_id' => $sel_id,
                        'productname' => 'PawTrails',
                        'sel_color' => $sel_color,
                        'sel_size' => $sel_size,
                        'deliverynumber' => $dNumber
                    ];
                }
            break;

            case 'address':
                if(!empty($_SESSION['delivery'])){
                    include ('submit_address.php');
                } else{
                    echo "<script>
                    alert('Your request failed, Please add product before you make delivery request.');
                    window.location.href='./delivery_request.php';
                    </script>";
                }
            break;
        }
    }


 
?>


<style>
	.hidedisplay{
		display: none!important;
	}

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
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
                <p>Please select the product you request</p>
            </ul>

        <!-- DataTables Example -->
        <div class="card mb-3" id="deliveryForm">
            <div class="card-header">
                <i class="fas fa-form"></i>
                Delivery Requests Form
            </div>

            <div class="card-body tab-content">
                <!--button to select which type of product you request-->
                <div class="tab">
                    <button class="tablinks btn btn-success" onclick="openSelectionForm(event, 'flyer_poster')">Flyers or Posters</button>
                    <button class="tablinks btn btn-warning" onclick="openSelectionForm(event, 'pawtrailsProduct')"> PawTrails</button>
                </div>

                <div id="flyer_poster" class="tabcontent">
                    <h4>Choose Flyers or Posters</h4> 
                    <form method="POST" id="form_flyer">
                        <input type="hidden"  name="makeaction" value="product">
                        <div class="form-group row">
                            <div class="col">
                                <label for="deliveryProduct">Product</label>
                            <br>
                                <select name="sel_product" id="sel_product" class="form-control" onchange="checkStock();" required>
                                    <?php
                                        $j = 0;

                                        $sql = mysqli_query($conn, "SELECT id, itemname, amount FROM pawtrails  WHERE itemtype = 'flyer' OR  itemtype =  'poster'");
                                        
                                        while ($row = $sql->fetch_assoc()){
                                            if($j == 0 ){
                                                $thisNumber = $row['amount'];
                                            }
                                            echo "<option amount='".$row['amount']."' value='".$row['id']." - ".$row['itemname']." - ".$row['amount']."'>" . $row['itemname'] . "</option>";
                                            $j++;
                                        }
                                    ?>
                                </select>
                            </div>
                       
                            <div class="col">
                                <label for="deliverynumber">Number of Products</label>
                                <input type="number" class="form-control" name="deliverynumber" id="deliverynumber" placeholder="number"  min="1" required>		
                            </div>
                            <!-- stock number-->
                            <div class="col">
                                <label for="stocknumber">stock Number</label>
                                <br>
                           
                             <span id="stocknumber"><?php echo $thisNumber; ?></span>
                            </div>

                        </div>
                        <!-- <input type="submit" name="AddProduct" class="btn btn-info"> -->
                        <button type="button" name="AddProduct" onclick="checkBeforeSubmit();" class="btn btn-info">Add Product</button>
                    </form>
                </div>
                
                <div id="pawtrailsProduct" class="tabcontent">
                    <h4 class="mt-3">Choose PawTrails Size and Color</h4>
                    <form method="POST">

                        <input type="hidden"  name="makeaction" value="pawtrailsSelect">

                        <div class="form-group row">
                            <div class="col">
                                <label for="deliveryProduct">Color</label>
                                <br>
                                <select name="sel_color" id="sel_color" class="form-control">
                            
                                        <option value="" selected disabled hidden>Choose here</option>
                                        <option value="red">red</option>
                                        <option value="black">black</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="deliverynumber">Size</label>
                                <br>
                                <select name="sel_size" id="sel_size" class="form-control" onchange="checkPawtrailsStock();">
                                    <option value="" selected disabled hidden>Choose here</option>
                                    <option value="small">small</option>
                                    <option value="medium">medium</option>
                                    <option value="large">large</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                                <div class="col">
                                    <label for="deliverynumber">Number of Products</label>
                                    <input type="number" class="form-control" name="deliverynumber" id="deliverynumber" placeholder="number"  min="1" required>		
                                </div>

                                 <div class="col">
                                    <label for="deliverynumber">Stock Number</label>
                                    <br>
                                    <span id="pawtrails_stock"><?php echo $maxQty; ?></span>
                                    
                                </div>
                        </div>
                        <button type="button" name="AddProduct" class="btn btn-info">AddProduct</button>
                    </form>
                </div>


                <!-- form to remove selected product from the session -->
                <form id="productDelete" method="POST">
                    <input type="hidden"  name="makeaction" value="productDelete">
                    <input id="prod2del" type="hidden"  name="prod2del" value="">
                </form>

                <!-- table to show selected product from the session -->
                <br>
                <h4>Request Item List</h4>
                <p><?php echo $msg ?></p>
                <div class="table-responsive">
                    <table class="table table-bordered" id="requestProductTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <!-- <th>item id</th> -->
                                <th>item Name</th>
                                <th>size</th>
                                <th>color</th>
                                <th>amount</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php    
                            if(!empty($_SESSION['delivery'])){
                                foreach($_SESSION['delivery'] as $i=> $k) {
                                    echo "<tr>
                                        <td>".$k['productname']."</td>
                                        <td>".$k['sel_color']."</td>
                                        <td>".$k['sel_size']."</td>
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
                            <input type="text" class="form-control" name="receivercompany" placeholder="receiver company">
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
                            <input type="text" class="form-control" name="inputAddress2" placeholder="1234 Main St">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAddress">Address3</label>
                            <input type="text" class="form-control" name="inputAddress3" placeholder="1234 Main St">
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
        //open selection form
        function openSelectionForm(evt, productname) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(productname).style.display = "block";
            evt.currentTarget.className += " active";
        }
 
        //Remove selected product from the session
        function deleteThisProduct(idP){
            $("#prod2del").val(idP);
            $("#productDelete").submit();
        }

        //check request item number is smaller than the stock
        function checkStock(){
             
            var e = document.getElementById("sel_product");
      
            var amount = e.options[e.selectedIndex].getAttribute('amount');
            document.getElementById('stocknumber').innerHTML = amount;
            return amount;
        }

        //
        function checkBeforeSubmit(){
            var qty =  document.getElementById('deliverynumber').value;
            qty = parseInt(qty);

            if(isNaN(qty) || qty == 0){
                alert('You have to enter a valid number');
                return false;
            }

            var maxQty = checkStock();
            if(qty > maxQty){
                alert('Out of Stock');
                return false;
            }
            document.getElementById('form_flyer').submit();
            return;
          
        }
	</script>

<?php
         //check pawtrails stock
         function checkPawtrailsStock(){
            if(isset($sel_color) && isset($sel_size)){
                alert($sel_color);
                $sql = "SELECT amount FROM pawtrails  WHERE color = '$sel_color' AND size = '$sel_size'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array()) {
                
                $maxQty = $row[0];
                }
            }else{
                $maxQty = 'select product first';
            }
        }

  $conn->close();
?>



<?php require_once('layouts/footer.php'); ?>

