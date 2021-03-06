
<?php

require_once('../inc/config.php');
if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
{
    header('location:index.php?lmsg=true');
    exit;

}
$requestUserID = $_SESSION['id'];

require_once('../layouts/header.php'); 
require_once('../layouts/side_bar.php'); 
require_once('../layouts/nav.php'); 

if($_POST) {
    switch($_POST['makeaction']) {
        case 'submitCustomRequest':
            include ('submit_customRequest.php');
        break;
    }
}

?>


<style>
.hidedisplay{
    display: none!important;
}
/***style for upload images**/
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}


</style>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Design Requests</li>
        </ol>
        <h1>Design Requests</h1>
        <hr>
        <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>
   
    <!-- DataTables Example -->
    <div class="card mb-3" id="deliveryForm">
        <div class="card-header">
            <i class="fas fa-form"></i>
            Requests Form
        </div>

        <div class="card-body tab-content">

            <h4>Item Details</h4>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"  enctype = "multipart/form-data">
                <input type="hidden"  name="makeaction" value="submitCustomRequest">
                <div class="form-group row">   
                    <div class="col">
                        <label for="customType">Select Type</label>
                        <br>
                        <select name="customType" id="customType" class="form-control" onchange="" required>
                            <option value="">Choose here</option>
                            <option value="flyer">Customised flyer</option>
                            <option value="poster">Customised poster</option>
                        </select>
                    </div>  
                     <div class="col">
                        <label for="vouchercode">Voucher code</label>
                        <input type="text" class="form-control" name="vouchercode" required>
                    </div>
                </div>    

                <div class="form-group row">
                    <div class="col">
                        <label for="companyname">Company Name</label>
                        <input type="text" class="form-control" name="companyname" placeholder="#####" required>
                    </div>
                    <div class="col">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" placeholder="number"  min="1" required>		
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <label for="usingdate">Date of using</label>
                        <input id="selectDate" onchange="validateDate()" type="date" class="form-control" name="usingdate" placeholder="Enter date" required>
                    </div>
                    <div class="col">
                    <label>Upload Logo</label>
                         <br>
                      <input type = "file" name = "image" required/>
                  
                    </div>
                </div>

                <p><strong>Note: Please upload jpg, jpeg, png, pdf format images. And the limit size is 5M.</strong></p>

                <div class="form-group">
                    <div class="form-check ml-3">
                        <input class="form-check-input" type="checkbox" id="gridCheck" required>
                        <label class="form-check-label" for="gridCheck">
                            I confirm all the information above are correct.
                        </label>
                    </div>
                </div>
                
                <input type="submit" class="btn btn-primary" value="Submit"/>
            </form>
        </div>

    </div>
</div>

<script>
     //check ship date to be at least one day after today
     function validateDate(){
            var userdate = new Date(document.getElementById("selectDate").value).toJSON().slice(0,10);
            var today = new Date().toJSON().slice(0,10);
            if(userdate < today){
            alert('Please select future date only!');
            }
        }
</script>

<?php require_once('../layouts/footer.php'); ?>	

