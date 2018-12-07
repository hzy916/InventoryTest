<?php
  	require_once('../inc/config.php');
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
        exit;
        $requestUserID = $_SESSION['id'];
	}

	require_once('../layouts/header.php'); 
	require_once('../layouts/side_bar.php'); 
  	require_once('../layouts/nav.php'); 

   //to check if they use resubmit because of reloading
   if(isset($_POST['makeaction'])){

        $doAction = true;

        switch($_POST['makeaction']) {
            case 'product': 
                list($pId,$pName,$maxAmount)=explode('-', $_POST['sel_product']);
                $dNumber = intval($_POST['deliverynumber']);

                switch(true) {
                    case ($dNumber == 0):
                        echo '<script> alert("You have to enter a valid number");</script>';
                        $doAction = false;
                    break;
                    case ($dNumber > $maxAmount):
                        echo '<script> alert("Out of Stock");</script>';
                        $doAction = false;
                    break;
                    case ($dNumber < 0):
                        echo '<script> alert("You have to enter a positive number");</script>';
                        $doAction = false;
                    break;
                    case ($dNumber < $maxAmount && $dNumber > 0):
                            //check if resubmit on reload the page
                        if($_POST['flyerToken']==$_SESSION['rand'] ){   
                            $_SESSION['delivery'][] = [
                                'product_id' => $pId,
                                'productname' => $pName,
                                'sel_color' => '/',
                                'sel_size' => '/',
                                'deliverynumber' => $dNumber
                            ];
                        }
                    break;
                }
          
            break;

            case 'productDelete':
                unset($_SESSION['delivery'][$_POST['prod2del']]);
            break;

            case 'pawtrailsSelect':
                //check if resubmit on reload the page
                if($_POST['pawtrailsToken']==$_SESSION['rand'] ){   
                     
                    if(!empty($_POST['sel_color'])&& !empty( $_POST['sel_size'])){
                        $sel_color = $_POST['sel_color'];
                        $sel_size = $_POST['sel_size'];

                        $sql = "SELECT id, amount FROM pawtrails  WHERE color = '$sel_color' AND size = '$sel_size'";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_array()) {
                            
                        $sel_id = $row['id']; 
                        $maxQty = $row['amount'];
                        }
                        
                        $dNumber = intval($_POST['deliverynumber']);

                        switch(true) {
                            case ($dNumber == 0):
                                echo '<script> alert("You have to enter a valid number");</script>';
                                $doAction = false;
                            break;
                            case ($dNumber > $maxQty):
                                echo '<script> alert("Out of Stock");</script>';
                                $doAction = false;
                            break;
                            case ($dNumber < 0):
                                echo '<script> alert("You have to enter a positive number");</script>';
                                $doAction = false;
                            break;
                            case ($dNumber < $maxQty && $dNumber > 0):
                                $_SESSION['delivery'][] = [
                                    'product_id' => $sel_id,
                                    'productname' => 'PawTrails',
                                    'sel_color' => $sel_color,
                                    'sel_size' => $sel_size,
                                    'deliverynumber' => $dNumber
                                ];
                            break;
                        }  
                    }else{
                        echo '<script> alert("Please select product first.");</script>';
                    }
                }
             
            break;

            
            case 'confirmaddress':
                if($_POST['randomcheck']==$_SESSION['rand'] ){  
                    //save all details in the session before user submit
                    $_SESSION['requestDetails'][0] = [
                        'company' => $_POST['receivercompany'],
                        'fullname' => $_POST['firstname'],
                        'phonenumber' => $_POST['phonenumber'],
                        'inputAddress1' => $_POST['inputAddress1'],
                        'inputAddress2' => $_POST['inputAddress2'],
                        'inputAddress3' => $_POST['inputAddress3'],
                        'inputCity' => $_POST['inputCity'],
                        'inputCountry' => $_POST['inputCountry'],
                        'inputPostcode' => $_POST['inputPostcode'],
                        'deliverydate' => $_POST['deliverydate'],
                        'receiverEmail' => $_POST['receiverEmail']
                    ];
                }
            break;

            case 'submitRequest':
                if(!empty($_SESSION['delivery']) && !empty($_SESSION['requestDetails'])){
                    include ('submit_shiprequest.php');
                } else{
                    echo 
                    "<script>
                        alert('Your request failed, Please add product before you make delivery request.');
                    </script>";
                }
            break;
        }
    }

    $NoItemDivView='block';
    $ItemDivView='none';
    
    if(isset($_SESSION['delivery']) && !empty($_SESSION['delivery'])){
        $NoItemDivView='none';
        $ItemDivView='block';     
    } 

    $rand=rand();
    $_SESSION['rand']=$rand;
 

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

  <link href="/assets/css/shipment.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">

  
  <script  src="/assets/js/index.js"></script>


    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../dashboard.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">New Shipment Request</li>
            </ol>
          
    
        <!-- MultiStep Form -->
            <div class="container">
        <!-- Step Wizard -->
                <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                            <a href="#step-1" type="button" class=" btn-primary btn-circle">Step 1</a>
                        
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-2" type="button" class="btn-default  btn-circle" disabled="disabled">Step 2</a>
                    
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-3" type="button" class=" btn-default btn-circle" disabled="disabled">Step 3</a>
                        
                        </div>
                    </div>
                </div>
                <!-- Step Wizard END -->
                <!-- quote form -->
                     <div class="form-horizontal" spellcheck="true"> 

                        <fieldset><!-- form contents -->
                            <!-- Wizard STEP 2 -->
                            <div class="row setup-content" id="step-1">
                                <div class="col-sm-12">
                                    <div class="form-group">
                            
                                        <div id="NoItemDiv" style="display:<?php echo $NoItemDivView ?>">
                                            <h2 class="fs-title">Shipment Contents</h2>
                                            <hr class="seperateLine">
                                            <img class="emptyItemIMG" src="https://cdn.shopify.com/s/files/1/2590/2182/files/Christmas2018-PawTrailsmin.png?8270276245400105272" src="Empty in your Request">
                                           
                                            <p class="noitemText">No Item in your shipment, please add item into your shipment </p>
                                                <button id="addItem" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> Add Item Into My Shipments</button>
                                            <br>

                                             <!-- form to remove selected product from the session -->
                                            <form id="productDelete" method="POST">
                                                <input type="hidden"  name="makeaction" value="productDelete">
                                                <input id="prod2del" type="hidden"  name="prod2del" value="">
                                            </form>
                                        </div>   

                                            <!-- table to show selected product from the session -->
                                        <div id="ItemDiv"  style="display:<?php echo $ItemDivView ?>">
                                            <div class="">
                                                <h4>Shipment Contents</h4>
                                                <button id="addItem_two" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> Add Item</button>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="requestProductTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th>item id</th> -->
                                                            <th>Product Name</th>
                                                            <th>Size</th>
                                                            <th>Color</th>
                                                            <th>Amount</th>
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
                                        </div>

                                        <!-- delete alert box -->
                                        <div id="dialog" title="Alert message" style="display: none">
                                            <div class="ui-dialog-content ui-widget-content">
                                                <p>
                                                    <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0"></span>
                                                    <label id="lblMessage">
                                                    </label>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- The Modal -->
                                        <div id="myModal" class="modal">
                                            <div class="modal-content">
                                                <span class="close">&times;</span>

                                                    <h5>Add Item into Shipment</h5> 
                                                    <!--button to select which type of product you request-->
                                                    <p>Item Details</p>
                                                    <label class="fieldLabel">Item Type</label>
                                                    <select id="itemtypeSelect"  onChange="handleSelection(value)">
                                                        <option value="" selected="selected"></option>
                                                        <option value="flyerForm">Flyer or Poster</option>
                                                        <option value="pawtrails_form">PawTrails All In One</option>   
                                                    </select>
                                                    <script>
                                              
                                                        function handleSelection(choice) {
                                                        //document.getElementById('select').disabled=true;
                                                        if(choice=='flyerForm')
                                                            {
                                                            document.getElementById(choice).style.display="block";
                                                            document.getElementById('pawtrails_form').style.display="none";
                                                            }
                                                            else
                                                            {
                                                            document.getElementById(choice).style.display="block";
                                                            document.getElementById('flyerForm').style.display="none";
                                                            }
                                                        }
                                                    </script>

                                                    <!-- The Form for flyer or posters-->
                              
                                                    <form name="flyerForm" method="POST" id="flyerForm">
                                                        <input type="hidden"  name="makeaction" value="product">
                                                        <!--set random number to check resumbit on refresh -->
                                                        <input type="hidden"  name="flyerToken" value="<?php echo $rand; ?>">
                                        
                                                        
                                                            <label class="fieldLabel" for="deliveryProduct">Product</label>
                                                        
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
                                                        
                                                
                                                        
                                                            <label class="fieldLabel" for="deliverynumber">Number of Products</label>
                                                            <input type="number" class="form-control" name="deliverynumber" id="deliverynumber" placeholder="number"  min="1" >		
                                                    
                                                        <!-- stock number-->
                                                        
                                                            <label class="fieldLabel" for="stocknumber">stock Number</label>

                                                            <span id="stocknumber"><?php echo $thisNumber; ?></span>
                                                       
                                                            <div>
                                                                <button type="button" name="AddProduct" onclick="checkBeforeSubmit();" class="btn addBtn">Add Now</button>
                                                                <button type="button" class=" cancel btn">Close</button>
                                                            </div>
                                                    </form>
                                          
                                                <!-- The Form for pawtrails all in one -->
                                            
                                                    <form name="pawtrails_form" method="POST" id="pawtrails_form" style="display:none">
                                                        <input type="hidden"  name="makeaction" value="pawtrailsSelect">

                                                        <!--set random number to check resumbit on refresh -->
                                                        <input type="hidden"  name="pawtrailsToken" value="<?php echo $rand; ?>">
                                               
                                                        <div class="form-group row">
                                                            <div class="col ss-item-required">
                                                                <label for="deliveryProduct">Color</label>
                                                                <br>
                                                                <select name="sel_color" id="sel_color" class="form-control" onchange="checkPawtrailsStock();">
                                                                        <option value="0" selected disabled hidden>Choose here</option>
                                                                        <option value="red">red</option>
                                                                        <option value="black">black</option>
                                                                </select>
                                                            </div>

                                                            <div class="col ss-item-required">
                                                                <label for="deliverynumber">Size</label>
                                                                <br>
                                                                <select name="sel_size" id="sel_size" class="form-control" onchange="checkPawtrailsStock();">
                                                                    <option value="0" selected disabled hidden>Choose here</option>
                                                                    <option value="small">small</option>
                                                                    <option value="medium">medium</option>
                                                                    <option value="large">large</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                                <div class="col ss-item-required">
                                                                    <label for="deliverynumber">Number of Products</label>
                                                                    <input type="number" class="form-control" name="deliverynumber" id="deliverynumber2" placeholder="number"  min="1" required>		
                                                                </div>

                                                                <div class="col ss-item-required">
                                                                    <label for="deliverynumber">Stock Number</label>
                                                                    <br>
                                                                    <span id="pawtrails_stock"></span>
                                                                </div>
                                                        </div>
                                                        <button type="button" name="AddProduct"  onclick="checkPawTrailsBeforeSubmit();" class="btn btn-info">Add Product</button>
                                                    </form>
                                                
                                            </div>
                                        </div>

                                        <hr class="seperateLine">
                                        <a href="/dashboard.php" name="cancel" class="cancel previous btn">Cancel</a>
                                    
                                        <button class="btn nextBtn next_btn" type="button" >Next<i class="fa fa-angle-double-right"></i></button>
                                
                                    </div>
                                </div>
                            </div>
                            <!-- Wizard STEP 1 END -->

                            <!-- Wizard STEP 2 -->
                            <div class="row setup-content" id="step-2">
                                <h2 class="fs-title">Receiver’s Details</h2>
                                <hr class="seperateLine">
                                                                    
                                <div class="col-sm-12">
                                <form  method="POST">
                                    <!--set random number to check resumbit on refresh -->
                                    <input type="hidden"  name="randomcheck" value="<?php echo $rand; ?>">
                                   
                                    <input type="hidden"  name="makeaction" value="confirmaddress">
                                    
                                    <?php
                                    //save user input in the session and allow user to edit it before submit
                                    $fullname='';
                                    $company='';
                                    $phonenumber='';
                                    $receiverEmail='';
                                    $inputAddress1='';
                                    $inputAddress2='';
                                    $inputAddress3='';
                                    $inputCity='';
                                    $inputPostcode='';
                                    $deliverydate='';

                                    if(!empty($_SESSION['requestDetails'])){
                                        $fullname=$_SESSION['requestDetails'][0]['fullname'];
                                        $company=$_SESSION['requestDetails'][0]['company'];
                                        $phonenumber=$_SESSION['requestDetails'][0]['phonenumber'];
                                        $receiverEmail=$_SESSION['requestDetails'][0]['receiverEmail'];
                                        $inputAddress1=$_SESSION['requestDetails'][0]['inputAddress1'];
                                        $inputAddress2=$_SESSION['requestDetails'][0]['inputAddress2'];
                                        $inputAddress3=$_SESSION['requestDetails'][0]['inputAddress3'];
                                        $inputCity=$_SESSION['requestDetails'][0]['inputCity'];
                                        $inputCountry=$_SESSION['requestDetails'][0]['inputCountry'];
                                        $inputPostcode=$_SESSION['requestDetails'][0]['inputPostcode'];
                                        $deliverydate=$_SESSION['requestDetails'][0]['deliverydate'];

                                    }
                                    ?>

                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="firstname">Full Contact Name</label>
                                            <input type="text" class="form-control" name="firstname" placeholder="#####" value="<?php echo  $fullname; ?>" required>
                                        
                                          
                                        </div>
                                        <div class="col">
                                            <label for="receivercompany">Company Name</label>
                                            <input type="text" class="form-control" name="receivercompany" placeholder="receiver company"  value="<?php echo  $company; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="receiverEmail">Receiver Email</label>
                                            <input type="email" class="form-control" name="receiverEmail" placeholder="receiver email" required  value="<?php echo  $receiverEmail; ?>">
                                        </div>

                                          <div class="col">
                                            <label for="phonenumber">Phone Number</label>
                                            <input type="text" class="form-control" name="phonenumber" placeholder="#####" value="<?php echo  $phonenumber; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <h2 class="fs-title">Shipping ADDRESS</h2>
                                    <hr class="seperateLine">
                                            
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="applicantName">Shipping Date</label>
                                            <input id="date" onchange="validateDate()" type="date" class="form-control" name="deliverydate" placeholder="Enter date" value="<?php echo  $deliverydate; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                    
                                        <div class="form-group col-md-4">
                                            <label for="inputAddress">Street / House No</label>
                                            <input type="text" class="form-control" name="inputAddress1" placeholder="1234 Main St" value="<?php echo  $inputAddress1; ?>" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputAddress">Address2</label>
                                            <input type="text" class="form-control" name="inputAddress2" placeholder="1234 Main St" value="<?php echo  $inputAddress2; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputAddress">Address3</label>
                                            <input type="text" class="form-control" name="inputAddress3" placeholder="1234 Main St" value="<?php echo  $inputAddress3; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label for="inputCountry">Country</label>
                                            <input type="text" class="form-control" name="inputCountry" value="<?php echo  $inputCountry; ?>" required>

                                            <!-- <select name="inputCountry" id="inputCountry" class="form-control" onchange="checkPawtrailsStock();">
                                                <option value="0" selected disabled hidden>Choose here</option>
                                                <option value="small">Ireland</option>
                                                <option value="medium">UK</option>
                                                <option value="large">France</option>
                                            </select> -->

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputCity">City</label>
                                            <input type="text" class="form-control" name="inputCity" value="<?php echo  $inputCity; ?>" required>
                                        </div>

                                      
                                        <div class="form-group col-md-4">
                                            <label for="inputPostcode">Postcode</label>
                                            <input type="text" class="form-control" name="inputPostcode" value="<?php echo  $inputPostcode; ?>" required>
                                        </div>
                                    </div>
                               
                                         <input type="button" name="previous" class="cancel previous btn" value="Back" />
                                        <button class="btn nextBtn next_btn" type="submit" >Next<i class="fa fa-angle-double-right"></i></button>                         
                                </form>
                              

                               
                                </div>
                                
                            </div>
                            <!-- Wizard STEP 2 END -->

                            <!-- Wizard STEP 3 -->
                            <div class="row setup-content" id="step-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                            
                                        <div class="form-group">
                                            <div class="form-check ml-3">
                                            <h2 class="fs-title">Final Review</h2>
                                             <hr class="seperateLine">
                                             <div class="row">
                                                <!--Receiver details in the session-->
                                                <div class="col-lg-6">
                                               
                                                        <?php    
                                                            if(!empty($_SESSION['requestDetails'])){
                                                                echo "  <h3>Receiver Details</h3>";
                                                                foreach($_SESSION['requestDetails'] as $i=> $k) {
                                                                    echo "
                                                                        <p>".$k['fullname']."</p>
                                                                        <p>".$k['company']."</p>
                                                                        <p>".$k['phonenumber']."</p>
                                                                        <p>".$k['receiverEmail']."</p>";
                                                                        $i++;
                                                                    }  
                                                            }
                                                        ?>
                                                </div>
                                               
                                                <!--Shipment address in the session-->
                                                <div class="col-lg-6">
                                                        <?php    
                                                            if(!empty($_SESSION['requestDetails'])){
                                                                echo "  <h3>Shipping Address</h3>";
                                                                foreach($_SESSION['requestDetails'] as $i=> $k) {
                                                                    echo "
                                                                        <p>".$k['inputAddress1']."</p>
                                                                        <p>".$k['inputAddress2']."</p>
                                                                        <p>".$k['inputAddress3']."</p>
                                                                        <p>".$k['receiverEmail']."</p>
                                                                        <p>".$k['inputCity']."</p>
                                                                        <p>".$k['inputCountry']."</p>
                                                                        <p>".$k['inputPostcode']."</p>";
                                                                        
                                                                        $i++;
                                                                    }  
                                                            }
                                                        ?>

                                                </div>
                                            </div>
                                                <!--Shipment Items in the session-->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="requestProductTable" width="100%" cellspacing="0">
                                                        <?php    
                                                            if(!empty($_SESSION['delivery'])){
                                                            echo "<h3>Shipment Contents</h3>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product Name</th>
                                                                        <th>Size</th>
                                                                        <th>Color</th>
                                                                        <th>Amount</th>
                                                                      
                                                                    </tr>
                                                                </thead>    
                                                                <tbody>";

                                                                foreach($_SESSION['delivery'] as $i=> $k) {
                                                                    echo "<tr>
                                                                        <td>".$k['productname']."</td>
                                                                        <td>".$k['sel_color']."</td>
                                                                        <td>".$k['sel_size']."</td>
                                                                        <td>".$k['deliverynumber']."</td>
                                                                   
                                                                        </tr>";
                                                                        $i++;
                                                                    }  
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <input class="form-check-input" type="checkbox" id="gridCheck" required>
                                                <label class="form-check-label" for="gridCheck">
                                                    I confirm all the information above are correct.
                                                </label>
                                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <form  method="POST">
                                    <!--set random number to check resumbit on refresh -->
                                    <input type="hidden" name="randomcheck" value="<?php echo $rand; ?>">
                                   
                                    <input type="hidden"  name="makeaction" value="submitRequest">
                                    
                                    <input type="button" name="previous" class="cancel previous btn" value="Back" />
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                           
                        </div>
                        </fieldset><!-- form contents END -->
                </div>
            </div>               
      
    </div>
</div>






    <script type="text/javascript">
   /****************/


    /****************/
    //Pop up form js

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("addItem");

    // Get the button that opens the modal
    var btn_two = document.getElementById("addItem_two");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

     // When the user clicks the button, open the modal 
     btn_two.onclick = function() {
        modal.style.display = "block";
    }


    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

  
        /****************/
        //check ship date to be at least one day after today
        function validateDate(){
            var userdate = new Date(document.getElementById("date").value).toJSON().slice(0,10);
            var today = new Date().toJSON().slice(0,10);
            if(userdate < today){
            alert('Please select future date only!');
            }
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
            document.getElementById('flyerForm').submit();
            return;
          
        }


        //check pawtrails before submit
        function checkPawTrailsBeforeSubmit(){
            var qty =  document.getElementById('deliverynumber2').value;
            qty = parseInt(qty);
            
            if(isNaN(qty) || qty == 0){
                alert('You have to enter a valid number');
                return false;
            }

            var maxQty = document.getElementById('pawtrails_stock').value;
            if(qty > maxQty){
                alert('Out of Stock');
                // return false;
            } else{
                document.getElementById('pawtrails_form').submit();
            } 
            return;
        }

         //check pawtrails stock
         function checkPawtrailsStock(){
             var color = document.getElementById('sel_color').options[document.getElementById('sel_color').selectedIndex].value;
             var size = document.getElementById('sel_size').options[document.getElementById('sel_size').selectedIndex].value;

           if(color != '0' && size != '0'){
              
               jQuery.ajax ({
                    type: 'POST',
                    async: true,
                    url: '/DeliveryRequests//getStock.php',
                    data: JSON.stringify({'color': color, 'size': size}),
                    dataType: 'JSON',
                    success: function (response) {
                        document.getElementById('pawtrails_stock').innerHTML = JSON.stringify(response);
                        // alert(JSON.stringify(response));

                        },
                    error: function (xhr, ajaxOptions, thrownError) {
                        // handle ajax errors
                        alert(JSON.stringify(xhr));
                        }
                    }) ;
               return;
           } 
        }

	</script>


<?php require_once('../layouts/footer.php'); ?>	

