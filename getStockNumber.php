<?php
  include "inc/config.php";
  $data = json_decode(file_get_contents('php://input'), true);
//   var_dump($data);
// exit;
//   $itemname = $_POST['itemname'];   // department id
  // $size = $_POST['sel_size'];

  $sql = "SELECT id, amount FROM pawtrails WHERE itemname = ".'"'.$data['itemname'].'"';
  // echo $sql;
  // exit;

  $result = mysqli_query($conn,$sql);
  $items_arr = array();

  while( $row = mysqli_fetch_array($result) ){
      $itemid = $row{'id'};
      $amount = $row{'amount'};
      $items_arr[] = array("id" => $itemid, "amount" => $amount);
  }

  // encoding array to json format
  echo json_encode($items_arr);
?>
