
<?php 
  //upload files        
  if(isset($_FILES['image'])){

    //all insert details
    $customType = mysqli_real_escape_string($conn,$_POST['customType']);
    $vouchercode =  mysqli_real_escape_string($conn,$_POST['vouchercode']);
    $companyname =  mysqli_real_escape_string($conn,$_POST['companyname']);
    $usingdate =  mysqli_real_escape_string($conn,$_POST['usingdate']);
    $quantity =  mysqli_real_escape_string($conn,$_POST['quantity']);


    //file name and extension preparation
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];

    $tmp = explode('.', $file_name);
   //rename the logo image with company name, voucher code and time
    $newfilename = $companyname . $vouchercode . round(microtime(true)) . '.' . end($tmp);

 
    $file_extension = end($tmp);
    $file_ext= strtolower($file_extension);

    // $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $expensions= array("jpeg","jpg","png","pdf");
    
    if(in_array($file_ext,$expensions)=== false){
       $errors[]="extension not allowed, please choose a JPEG or PNG file.";
       
       echo "<script type=\"text/javascript\">".
       "alert('extension not allowed, please choose a JPEG, PNG, or PDF file');".
       "</script>";
    }
    
    if($file_size > 5242880) {
       $errors[]='File size must be smaller than 5 MB';
       echo "<script type=\"text/javascript\">".
       "alert('File size must be smaller than 5 MB');".
       "</script>";
    }
    
    if(empty($errors)==true) {
       move_uploaded_file($file_tmp,"uploads/".$newfilename);
      
      //  exit;
     $filepath = "uploads/".$newfilename;

        //insert new request after image is uploaded    
        $realfilepath =   mysqli_real_escape_string($conn,$filepath); 

        //Insert Custom Request details
        $sql= "INSERT INTO CustomRequest (UseDate, c_RequestStatusID, c_RequestEmployeeID, voucherCode, companyName, uploadLogo, quantity, itemType) VALUES ('$usingdate', '1', '$requestUserID', '$vouchercode', '$companyname', '$realfilepath', '$quantity', '$customType')";
        
        if($conn->query($sql) === TRUE) {
            //Grab the value of request items
            echo "<script type=\"text/javascript\">".
            "alert('Your submitted a Customised Item Request successfully.');".
            "window.location.href='./custom_request_table.php';".
            "</script>";

        } else {
            // $msg = "Updating failed.";
            echo "Error " . $sql . ' ' . $conn->connect_error;
            // echo "<script type=\"text/javascript\">".
            // "alert('Your Delivery Request submit failed.');".
            // "</script>";
        }

    }else{
      //  print_r($errors);
       echo "<script type=\"text/javascript\">".
       "alert('Logo upload failed, Please double check the valid logo format');".
       "</script>";
    }
 } 

       

 
?>