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
                    case ($dNumber <= $maxAmount && $dNumber > 0):
                            //check if resubmit on reload the page
                        if($_POST['flyerToken']==$_SESSION['rand'] ){   
                            $_SESSION['delivery'][] = [
                                'product_id' => $pId,
                                'productname' => $pName,
                                'sel_color' => '',
                                'sel_size' => '',
                                'deliverynumber' => $dNumber
                            ];
                        }
                    break;
                }
            //    print('number '.$dNumber .'<br>');
            //    print('max '.$maxAmount);
            //     exit;
          
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
                            case ($dNumber <= $maxQty && $dNumber > 0):
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

            case 'submitRequest':
                if(!empty($_SESSION['delivery']) && $_POST['randomcheck']==$_SESSION['rand']){
                    //refresh the token in the session before user reload
                    $_SESSION['rand']=rand();
                    include ('submit_shiprequest.php');
                } else{
                    echo 
                    "<script>
                        alert('you are not allowed to refreshing page.');
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
        $disable='';  
    } else{
        $disable='disabled';  
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

/***custom alert style**/
    #confirm {
    display: none;
    background-color: #91FF00;
    border: 1px solid #aaa;
    position: fixed;
    width: 250px;
    left: 50%;
    margin-left: -100px;
    padding: 6px 8px 8px;
    box-sizing: border-box;
    text-align: center;
    }
    #confirm button {
    background-color: #48E5DA;
    display: inline-block;
    border-radius: 5px;
    border: 1px solid #aaa;
    padding: 5px;
    text-align: center;
    width: 80px;
    cursor: pointer;
    }
    #confirm .message {
    text-align: left;
    }

    .add_item_btn{
        float:right;
    }
    
    /**prev and next button on the same row and responsive stack in mobile*/
 
  
    @media screen and (max-width: 400px) {
        .previous { 
            width: 100px!important;
        }
        .next { 
            width: 100px!important;
        }
    }

    /*center the form input for bigger screens*/
    /**not using common center method cause the hr and h1 element inside the form*/
   
       .halfwidth{
           margin-left:20%;
       } 
  
    @media (max-width:400px){
        .confirmLabel{
           text-align:left;
       }
       .halfwidth{
           margin-left:-15px;
       } 
    }

    

</style>

  <link href="/assets/css/shipment.css" rel="stylesheet" />
  <link href="/assets/css/multistep.css" rel="stylesheet" />


    <!-- The Modal for adding products -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

                <h3 class="add_title">Add Item into Shipment</h3> 
                <!--button to select which type of product you request-->
                <h4 class="itemDetails">Item Details</h4>
                
                <div class="selectBox">
                    
                    <div class="form-group">
                        <label class="fieldLabel col-xs-2">Item Type</label>
                        <div class="col-xs-10 oneline redNote">
                            <select id="itemtypeSelect" class="form-control" onChange="handleSelection(value)">
                                <option value="" selected="selected">Please select type</option>
                                <option value="flyerForm">Flyer or Poster</option>
                                <option value="pawtrails_form">PawTrails All In One</option>   
                            </select>
                        </div>
                    </div>

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

                <form name="flyerForm" class="form-horizontal" method="POST" id="flyerForm">
                    <input type="hidden"  name="makeaction" value="product">
                    <!--set random number to check resumbit on refresh -->
                    <input type="hidden"  name="flyerToken" value="<?php echo $rand; ?>">

                    <div class="form-group">    
                        <label class="fieldLabel col-xs-2" for="deliveryProduct">Item</label>
                        
                        <div class="col-xs-10 oneline redNote">
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
                    </div>

                    <!-- stock number-->
                    <div class="form-group">    
                        <label class="fieldLabel col-xs-2" for="stocknumber">Stock Number</label>
                        <div class="col-xs-10 oneline">
                            <span id="stocknumber"><?php echo $thisNumber; ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">   
                        <label class="fieldLabel col-xs-2" for="deliverynumber">Number</label>
                        <div class="col-xs-10 oneline redNote">
                        
                            <input type="number" class="form-control" name="deliverynumber" id="deliverynumber" placeholder="number"  min="1" >		
                        </div>
                    </div>  
                        <button type="button" name="AddProduct" onclick="checkBeforeSubmit();" class="addBtn mt-5 mb-3">Add Now</button>
   
                </form>
        
            <!-- The Form for pawtrails all in one -->
        
                <form name="pawtrails_form" method="POST" id="pawtrails_form" style="display:none">
                    <input type="hidden"  name="makeaction" value="pawtrailsSelect">

                    <!--set random number to check resumbit on refresh -->
                    <input type="hidden"  name="pawtrailsToken" value="<?php echo $rand; ?>">
                    
                    <label class="fieldLabel" for="deliveryProduct">Color</label>
                    
                    <div class="oneline redNote">
                        <select name="sel_color" id="sel_color" class="form-control" onchange="checkPawtrailsStock();">
                                <option value="0" selected disabled hidden>Choose here</option>
                                <option value="red">red</option>
                                <option value="black">black</option>
                        </select>
                    </div>
                    
                    <label class="fieldLabel" for="deliverynumber">Size</label>
                    
                    <div class="oneline redNote">
                        <select name="sel_size" id="sel_size" class="form-control" onchange="checkPawtrailsStock();">
                            <option value="0" selected disabled hidden>Choose here</option>
                            <option value="small">small</option>
                            <option value="medium">medium</option>
                            <option value="large">large</option>
                        </select>
                    </div>
                    

                    <label class="fieldLabel" for="deliverynumber">Stock Number</label>
                    
                    <div class="oneline">
                        <span id="pawtrails_stock"></span>
                    </div>
                    
                    <label class="fieldLabel" for="deliverynumber">Number</label>       
            
                    <div class="oneline redNote">
                        <input type="number" class="form-control" name="deliverynumber" id="deliverynumber2" placeholder="number"  min="1" required>		
                    </div>  
                    

                    <button type="button" name="AddProduct"  onclick="checkPawTrailsBeforeSubmit();" class="mt-5 mb-3 addBtn">Add Now</button>
                </form>
            </div>
        </div>
    </div>
    <!-- ENd of The alert Modal -->

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
        <div class="Customcontainer"> 
            <div id="msform"><!-- form contents -->
            	<!-- progressbar -->
                <ul id="progressbar" class="arrow-steps">
                    <li class="active step"></li>
                    <li class="step"></li>
                    <li class="step"></li>
                </ul>
                <!-- Wizard STEP 1 -->
                <div class="fieldset row setup-content" id="step1">
                    <div class="col-sm-12 form_content">
                        <div class="">
                            <div id="NoItemDiv" style="display:<?php echo $NoItemDivView ?>">
                                <h2 class="fs-title">Shipment Contents</h2>
                                <hr class="seperateLine">
                                <img class="emptyItemIMG" src="/assets/img/shipment_item_none.png" src="Empty in your Request">
                                
                                <p class="noitemText">No Item in your shipment, please add item into your shipment </p>
                                    <button id="addItem" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> Add Item Into My Shipments</button>
                                <br>

                                    <!-- form to remove selected product from the session-->
                                <form id="productDelete" method="POST">
                                    <input type="hidden"  name="makeaction" value="productDelete">
                                    <input id="prod2del" type="hidden"  name="prod2del" value="">
                                </form> 
                            </div>   

                                <!-- table to show selected product from the session -->
                            <div id="ItemDiv"  style="display:<?php echo $ItemDivView ?>">
                                <div class="shipcontent">
                                    <h4>Shipment Contents</h4>
                                    <hr class="seperateLine">
                                 
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
                                                <th class="add_item_btn"><button id="addItem_two" class="shipbutton btn btn-1 mb-3"><i class="fa fa-plus"></i> Add Item</button></th>
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
                                                            <a class='removeItem' id=".$i."><i class='fa fa-edit'></i></a>
                                                            <a class='removeItem' id=".$i."><i class='fa fa-trash'></i></a>
                                                        </td>
                                                        <td></td>
                                                        </tr>";
                                                        $i++;
                                                    }  
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                     
                            <!-- <div id="dialog" title="Alert message" style="display: none">
                                <div class="ui-dialog-content ui-widget-content">
                                    <p>
                                        <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0"></span>
                                        <label id="lblMessage">
                                        </label>
                                    </p>
                                </div>
                            </div> -->

                        
                            
                        </div>

                        
                    </div>
                  
                    <div class="col-sm-12 topline">
                        <hr class="seperateLine">
                        <button name="cancel" onclick="getConfirmation();" class="cancel previous btn">Cancel</button>
                        
                        <input id="next1" type="button" name="next" class="next action-button" value="Next" <?php echo $disable;  ?> />
                    </div>
                </div>
                <!-- Wizard STEP 1 END -->

                <!-- Wizard STEP 2 -->
                <div class="fieldset row setup-content" id="step2">
                    <h2 class="fs-title">Receiver’s Details</h2>
                    <hr class="seperateLine">
                                                        
                    <div class="col-sm-12 centerFormdiv">
                        <form data-toggle="validator" role="form" method="POST" id='realForm'>
                        <!--set random number to check resumbit on refresh -->
                            <input type="hidden"  name="randomcheck" value="<?php echo $rand; ?>">

                            <div class="form-group row halfwidth">
                              
                                <label class="confirmLabel" for="firstname">Full Contact Name</label>
                                <div class="redNote"> 
                                    <input type="text" class="form-control" name="firstname" placeholder="#####" onChange="javascript:copytoStepThree(this.value,'receiverName')" >
                                </div>
                              
                               
                            </div>

                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="receivercompany">Company Name</label>
                                <div class="">
                                    <input type="text" class="form-control" name="receivercompany" placeholder="receiver company"  onChange="javascript:copytoStepThree(this.value,'companyName')">
                                </div>
                               
                            </div>


                            <div class="form-group row halfwidth">
                                <label  class="confirmLabel" for="receiverEmail">Receiver Email</label>
                                <div class="redNote">
                                    <input type="email" class="form-control" name="receiverEmail" placeholder="receiver email" onChange="javascript:copytoStepThree(this.value,'receiverEmail')" >
                                </div>
                                
                            </div>    
                            
                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="phonenumber">Phone Number</label>
                                <div class="redNote">
                                    <input type="text" class="form-control" name="phonenumber" placeholder="#####" onChange="javascript:copytoStepThree(this.value,'receiverPhone')" >
                                </div>
                                
                            </div> 
                            
                            <h2 class="fs-title">Shipping ADDRESS</h2>
                            <hr class="seperateLine">
                            

                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="inputAddress">Street / House No</label>
                                <div class="redNote">
                                    <input type="text" class="form-control" name="inputAddress1" placeholder="1234 Main St" onChange="javascript:copytoStepThree(this.value,'receiverAddress1')" >
                                </div>
                                
                            </div>

                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="inputAddress">Address2</label>
                                <div class="redNote">
                                    <input type="text" class="form-control" name="inputAddress2" placeholder="1234 Main St" onChange="javascript:copytoStepThree(this.value,'receiverAddress2')">
                                </div>
                                <!-- <span id="firstname-error">This field is required.</span> -->
                            </div>   
                            
                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="inputAddress">Address3</label>
                                <div class="">
                                    <input type="text" class="form-control" name="inputAddress3" placeholder="1234 Main St" onChange="javascript:copytoStepThree(this.value,'receiverAddress3')" >
                                </div>
                            </div> 


                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="inputCountry">Country</label>
                                <div class="redNote">
                                    <select name="inputCountry" class="redNote form-control" onChange="javascript:copytoStepThree(this.value,'receiverCountry')"> 
                                        <option value="" selected="selected">Please select country</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="UK">UK</option>
                                        <option value="France">France</option>
                                    </select>
                                </div>
                               
                            </div>

                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="inputCity">City</label>
                                <div class="redNote">
                                    <input type="text" class="form-control" name="inputCity" onChange="javascript:copytoStepThree(this.value,'receiverCity')" >
                                </div>
                              
                            </div>
                            
                            <div class="form-group row halfwidth">
                                <label class="confirmLabel" for="inputPostcode">Postcode</label>
                                <div class="redNote">
                                    <input type="text" class="form-control" name="inputPostcode" onChange="javascript:copytoStepThree(this.value,'receiverPostcode')" >
                                </div> 
                              
                            </div>
                    </div>

                    <hr class="seperateLine">
                        <input type="button" name="previous" class="previous cancel action-button" value="Previous" />
                        <input type="button" name="next" class="next action-button" value="Next" />
                </div>
                <!-- Wizard STEP 2 END -->

                <!-- Wizard STEP 3 -->
                <div class="fieldset row setup-content" id="step3">
                    <div class="col-sm-12">
                         
                                <div class="form-check ml-3">
                                    <h2 class="fs-title">Final Review</h2>
                                    <hr class="seperateLine">
                                    <div class="row">
                                        <!--Receiver details in the session-->
                                        <div class="card card-tasks col-md-6">

                                            <div class="card-header">
                                                <h4 class="card-title contentheader">Receiver Details</h4>
                                            </div>
                                            <hr>
                                            <div class="card-body contenttable">
                                               
                                                    <p id="receiverName"></p>
                                                    <p id="companyName"></p>
                                                    <p id="receiverEmail"></p>
                                                    <p id="receiverPhone"></p>
                                                    <p id="shipDate"></p>
                                             
                                            </div>
                                        </div>

                                    <!--Shipment address in the session-->
                                        <div class="card  card-tasks col-md-6">
                                            <div class="card-header">
                                                <h4 class="card-title contentheader">Shipping Address</h4>
                                            </div>
                                            <hr>
                                            <div class="card-body contenttable">
                                                    <p id="receiverAddress1"></p>
                                                    <p id="receiverAddress2"></p>
                                                    <p id="receiverAddress3"></p>
                                                    <p id="receiverCity"></p>
                                                    <p id="receiverCountry"></p>
                                                    <p id="receiverPostcode"></p>
                                            </div>   
                                        </div> 
                                    </div>
                                  
                                    <div class="row card table-responsive">
                                        <!--Shipment Items in the session-->
                                        <div class="card-header">
                                            <h4 class="card-title contentheader">Shipment Contents</h4>
                                        </div>
                                        <div class="card-body contenttable table row" id="requestProductTable" width="100%" cellspacing="0">
                                            <?php    
                                                if(!empty($_SESSION['delivery'])){
                                                    foreach($_SESSION['delivery'] as $i=> $k) {
                                                        echo "<div class='col-md-4'>
                                                                <p class='itemlist'>".$k['productname']." ".$k['sel_color']." ".$k['sel_size'].    "             x           ".$k['deliverynumber']."</p>
                                                            
                                                               
                                                            </div>";
                                                            $i++;
                                                        }  
                                                }
                                            ?>
                                         
                                        </div>
                                    </div>
                                    <hr>
                                              
                                </div>

                </div>
                
                    <!--checkbox for user to confirm-->
                    <div class="checkboxlabel">
                        <input class="form-check-input" type="checkbox" name="checkbox" id="gridCheck" required>
                        <label id="confirmLabel" class="form-check-label" for="gridCheck">
                            I confirm all the data submitted are correct.
                        </label>    
                    </div>
                  

                    <input type="button" name="previous" class="previous cancel action-button" value="Previous" />

                    <input type="hidden"  name="makeaction" value="submitRequest">
                    <button type="button" class="submitBTN btn btn-primary" onclick="return IsTermChecked();">Submit</button>

                </form>                
            </div>  
            <!-- Wizard STEP 3 END -->
        </div> 
    </div>
</div>

<!-- jQuery easing plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" type="text/javascript"></script>
<!--jquery validation plugin-->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"></script>


<script>

 //check checkbox is checked on step3 //
 function IsTermChecked() {
        if (!$("#gridCheck").is(":checked")) {
            $("#confirmLabel").addClass("becomeRed");
            alert('Please confirm all the data first');
            return;
        }
        else
     
        document.getElementById('realForm').submit();
    }

     //check if all required fields are filled in js when user click next//
     //////////////////////////////////////////////////////////////
                                           
    //print all the values on step 3
    function copytoStepThree($val,$dest) {
        $('#'+$dest).html($val);
    }

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches


$(".next").click(function(){
    // alert('clicked');
    
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	

    // //custom validation on next button
    var form = $("#realForm");
    // console.log(form);
    
        form.validate({
            errorElement: 'span',
            errorClass: 'help-block',
            // errorPlacement: function (error, element) {
            //     error.insertAfter('.redNote');
            // },

            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            rules: {
                firstname: {
                    required: true,
                },
                receiverEmail : {
                    required: true,
                },
                phonenumber : {
                    required: true,
                   
                },
            
                inputAddress1:{
                    required: true,
                },
                inputAddress2:{
                    required: true,
                },
           
                inputCountry: {
                    required: true,
                  
                },
                inputCity: {
                    required: true,
                },
                inputPostcode: {
                    required: true,
                },
            },
            messages: {
                username: {
                    required: 
                    "This field is required",
                },
                receiverEmail : {
                    required: "receiver Email required",
                },
                phonenumber : {
                    required:"This field is required",
                },
            
                inputAddress1: {
                    required: "This field is required",
                },
                inputAddress2: {
                    required: "This field is required",
                },
                inputCountry: {
                    required: "This field is required",
                },
                inputCity: {
                    required: "This field is required",
                },
                inputPostcode: {
                    required: "This field is required",
                },
            }
        
            // errorElement: 'span',
            // errorLabelContainer:'.errorTxt'
        });
    // //end of custom validation on next button
    // alert(form.valid());

    if (form.valid() === true){
        // alert('good');
             if ($('#step1').is(":visible")){
                current_fs = $('#step1');
                next_fs = $('#step2');
            }else if($('#step2').is(":visible")){
                current_fs = $('#step2');
                next_fs = $('#step3');
            }
    
        //activate next step on progressbar using the index of next_fs
	    $("#progressbar li").eq($(".fieldset").index(next_fs)).addClass("active");
	
        //show the next fieldset
        next_fs.show(); 
    
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});

    } //end of custom validation on if
    else{
        alert('Please fill all required fields.');
    }
    animating = false;

});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($(".fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});


</script>


    <script type="text/javascript">
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

  

        //Remove selected product from the session and pop up confirm box before delete
        $(".removeItem").click(function(){
        var id = $(this).attr("id");
        // alert(id);
   
        if(confirm('Are you sure?'))
        {
            $("#prod2del").val(id);
           $("#productDelete").submit();
        }
    });

        //custom style for alert when user click cancel button
        function getConfirmation(){
            var retVal = confirm("Do you want to cancel this request, your input form data will not be saved.");
               if( retVal == true ){
                   //clear the item session and redirect to dashboard
                    $.ajax({
                        type: 'POST',
                        url: '/DeliveryRequests/deleteItem_Session.php',
                        data: "action=unsetsession",
                        success: function(msg) {
                           window.location.href = '../dashboard.php';
                        },
                        error:function(msg){
                            alert('your item is not cleared in the session, you can do your request later');
                            console.log(msg);
                        }
                    });
                return true;
               }
               else{
                  
                  return false;
                  window.location.href = './DeliveryRequests/ship.php';
               }
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
                // alert('submit');
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

