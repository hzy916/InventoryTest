
<?php

    require 'inc/config.php';

    if(isset($_FILES['image'])  && $_POST['randomcheck']==$_SESSION['rand']){
            //file name and extension preparation
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];

            $tmp = explode('.', $file_name);
            // $path_parts = pathinfo($tmp);
            // $file = $path_parts['filename'];
            //rename the logo image with company name, voucher code and time
            $newfilename =  round(microtime(true)) . '.' . end($tmp);
            // print_r($newfilename);
            // exit;

                $file_extension = end($tmp);
                $file_ext= strtolower($file_extension);
                $expensions= array("jpeg","jpg","png","pdf");
                
                if(in_array($file_ext,$expensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                
                echo "<script type=\"text/javascript\">".
                "alert('extension not allowed, please choose a JPEG, PNG, or PDF file');".
                "</script>";
                }
                if($file_size > 5242880) {
                $errors[]='File size must be smaller 5 MB';
                echo "<script type=\"text/javascript\">".
                "alert('File size must be smaller than 5 MB');".
             
                "</script>";
                }
                
                if(empty($errors)==true) {

                //use FTP method to upload 
                // connect and login to FTP server
                $ftp_server = "localhost";
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, 'ziyun', 'XiangShou2018JinTian');

                // upload file
                if (ftp_put($ftp_conn, "/testweb.pawtrails.com/web/InventoryTest/DesignUpload/".$newfilename, $file_tmp, FTP_ASCII))
                {
                echo "Successfully uploaded $file_tmp.";
                }
                else
                {
                echo "Error uploading $file_tmp.";
                }

                // close connection
                ftp_close($ftp_conn);

                $filepath = "DesignUpload/".$newfilename;

                //insert new request after image is uploaded    
                $realfilepath =  mysqli_real_escape_string($conn,$filepath); 
                //Insert Custom Request details
                $sql= "UPDATE CustomRequest SET DesignFilePath = '$realfilepath'";
                    
                if($conn->query($sql) === TRUE) {
                        //Grab the value of request items
                        echo "<script type=\"text/javascript\">".
                        "alert('You submitted the Customised Design successfully.');".
                   
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
    
   include('check_custom_request.php');
?>