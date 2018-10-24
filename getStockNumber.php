<?php
  include "inc/config.php";

  $itemname = $_POST['itemname'];   // department id
  // $size = $_POST['sel_size'];

  $sql = "SELECT id,amount FROM pawtrails WHERE itemname=".$itemname;

  $result = mysqli_query($con,$sql);

  $users_arr = array();

  while( $row = mysqli_fetch_array($result) ){
      $userid = $row['id'];
      $amount = $row['amount'];

      $users_arr[] = array("id" => $userid, "amount" => $amount);
  }

  // encoding array to json format
  echo json_encode($users_arr);

?>
