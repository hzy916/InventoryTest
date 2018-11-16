<?php
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];

    $tmp = explode('.', $file_name);
    $file_extension = end($tmp);
    $file_ext= strtolower($file_extension);

    // $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $expensions= array("jpeg","jpg","png");
    
    if(in_array($file_ext,$expensions)=== false){
       $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    
    if($file_size > 2097152) {
       $errors[]='File size must be smaller 5 MB';
    }
    
    if(empty($errors)==true) {

      //use FTP method to upload 
      // connect and login to FTP server
      $ftp_server = "localhost";
      $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
      $login = ftp_login($ftp_conn, 'ziyun', 'XiangShou2018JinTian');

    

      // upload file
      if (ftp_put($ftp_conn, "/testweb.pawtrails.com/web/InventoryTest/uploads/".$file_name, $file_tmp, FTP_ASCII))
      {
      echo "Successfully uploaded $file_tmp.";
      }
      else
      {
      echo "Error uploading $file_tmp.";
      }

      // close connection
      ftp_close($ftp_conn);
      //  move_uploaded_file($file_tmp,"uploads/".$file_name);
      //  echo "<script type=\"text/javascript\">".
      //  "alert('Logo was uploaded successfully.');".
      //  "window.location.href='./custom_item_request.php';".
      //  "</script>";

    }else{
       print_r($errors);
    }
 }
?>